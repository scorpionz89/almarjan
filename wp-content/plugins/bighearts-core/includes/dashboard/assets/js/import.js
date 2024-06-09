/* global redux_change, wp */

(function($) {
    "use strict";
    $(document).ready(function() {
        $.fn.wglImporter();
    });
    $.fn.wglImporter = function() {

        $('.wgl-custom-pages .select2').select2({placeholder: "Select a Page"});

        $('.wgl_import_option').on('change', function() {
            if('partial' === $(this).val()){
                jQuery('.wrap-importer').hide();
                jQuery('.wrap-importer.pages').show();
                jQuery('.wrap-importer.partial-options').show();
                $('.select2-custom-pages').select2();
            }else{
                jQuery('.wrap-importer').hide();
            }
        });

        var Progress = {
            show: function (){
                jQuery(this).find('.importer_status').css({ 'opacity' : '1'});
            },
            addPercents: function (i, count) {
                var container = 100 / count;
                container = container.toFixed(1);
                i--;
                
                var number = i * container;
                number = number > 99 ? 100 : number;                
                this.find('.importer_status .progressbar .progressbar_filled').css(
                    'width', number + '%'
                );
                this.find('.importer_status .progressbar .progressbar_content').css(
                    'width', number + '%'
                );

                this.find('.importer_status .progressbar_value').html(number + '%');
            },
            error: function (xhr, textStatus, errorThrown) {
                console.warn('was 500 (Internal Server Error) but we try to load import again');
                if (typeof this.tryCount !== "number") this.tryCount = 1;
                switch (true) {
                    case (this.tryCount < 10):
                        this.tryCount++;
                        this.data = this.data + '&re_import_item=1';
                        console.log(this);
                        jQuery.post(this).fail(Progress.error);
                        break;
                    default:
                        alert('There was an error importing demo content. Please reload page and try again.');
                }
            }
        }

        $('.theme-actions .import-demo-data').unbind('click').on('click', function(e) {
            e.preventDefault();
            
            var option_name = jQuery(this).closest('.wgl_importer').find('.wgl_import_option').val();
            var parent = jQuery(this).closest('.themes');
            
            var message = 'Import Demo Content?';
            var r = confirm(message);
            if (r == false) return;
                   
            Progress.show.call(parent);

            var data = jQuery(this).data();    
            
            var custom_pages, count_pages;
            count_pages = 1;

            if(option_name === 'partial'){
                custom_pages = jQuery(this).closest('.themes').find('.select2-custom-pages').val();
                data.custom_pages = true;
                data.type_option = [];
                if(custom_pages){
                    count_pages = custom_pages.length;
                    data.type_option.push('custom_pages');
                    data.selectedPages = JSON.parse(JSON.stringify(custom_pages));                    
                }
                if(jQuery(this).closest('.themes').find('#widgets').is(":checked")){
                    data.type_option.push('widgets');
                    count_pages++;
                }
                if(jQuery(this).closest('.themes').find('#options').is(":checked")){
                    data.type_option.push('options');
                    count_pages++;
                }
                if(jQuery(this).closest('.themes').find('#rev-slider').is(":checked")){
                    data.type_option.push('rev_slider');
                    count_pages++;
                }
                var selectedCPT = {};
                jQuery(this).closest('.themes').find('.сpt-wrapper input').each(function(){
                    if(jQuery(this).is(":checked")){
                        selectedCPT[jQuery(this).data('folder')] =  jQuery(this).attr('name');
                        count_pages++;
                    }
                }); 

                data.selectedCPT = JSON.parse(JSON.stringify(selectedCPT));
                data.type_option = JSON.parse(JSON.stringify(data.type_option));
            }else if(option_name === 'all'){
                count_pages = 10;
            }

            data.action = "wgl_importer";
            data.demo_import_pages_id = parent.find('.pages').attr("data-demo-id");
            data.demo_import_full_id = parent.find('.full').attr("data-demo-id");
            data.demo_import_cpt_id = parent.find('.cpt').attr("data-demo-id");
            data.nonce = parent.attr("data-nonce");
            data.type = 'import-demo-content';
            data.content = 1;
            data.count_pages = count_pages;
            parent.find('.wgl_image').css('opacity', '0.5');
            parent.find('.import__select').addClass('active_import');
            parent.find('.import__select .overlay__import').css('opacity', '0.5');
            parent.find('#info-opt-info-success').hide();

            loadContent(parent, data, count_pages);            

            return false;
        });

        function loadContent(parent, data, count = false) {
            jQuery.post(ajaxurl, data, function(response) {
                if (response.length > 0 && response.match(/Have fun!/gi)) {
                    data.content++;
                    var itemCount = count ? count : 10;
                    Progress.addPercents.call(parent, data.content, itemCount);
                    
                    if (data.content > itemCount) {
                        console.log('Finished');
                        parent.find('.wgl_image').css('opacity', '1');
                        parent.find('.import__select').removeClass('active_import');
                        parent.find('.import__select .overlay__import').css('opacity', '0');
                        parent.find('#info-opt-info-success').show('slow');
                    } else {
                        loadContent(parent, data, count);
                    }
                } else if(response.match(/cURL error/gi)){
                    //debugger;
                    data.without_image = true;
                    console.log('Connection timeout');
                    loadContent(parent, data, count);
                } else { 
                    parent.find('.import-demo-data').show();
                    alert('There was an error importing demo content: \n\n' + response.replace(/(<([^>]+)>)/gi, ""));
                }    
            }).fail(Progress.error)
        }

        $('.not-license').unbind('click').on('click', function(e) {
            e.preventDefault();
            window.location.href = jQuery(this).data('url');
            return false;
        });
    };

})(jQuery);