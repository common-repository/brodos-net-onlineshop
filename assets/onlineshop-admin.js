jQuery(document).ready(function ($) {
    jQuery('#brodos_cat_type').on('change', function () {
        if (this.value == "") {
            jQuery('#brodos_cat_text').attr('placeholder', '');
        } else {
            placegolder = $('option:selected', this).attr('data-placeholder');
            jQuery('#brodos_cat_text').attr('placeholder', placegolder);
        }
    });
    jQuery('#brodos_search_group_type').on('change', function () {
        if (this.value == "") {
            jQuery('#brodos_search_group_text').attr('placeholder', '');
        } else {
            placegolder = $('option:selected', this).attr('data-placeholder');
            jQuery('#brodos_search_group_text').attr('placeholder', placegolder);
        }
    });
    jQuery('#brodos_article_linking_type').on('change', function () {
        if (this.value == "") {
            jQuery('#brodos_article_linking_text').attr('placeholder', '');
        } else {
            placegolder = $('option:selected', this).attr('data-placeholder');
            jQuery('#brodos_article_linking_text').attr('placeholder', placegolder);
        }
    });
    if (jQuery('.shortcodeDisplay').length) {
        adminBar = 0;
        if (jQuery('#wpadminbar').length) {
            adminBar = jQuery('#wpadminbar').outerHeight(true);
        }
        jQuery('html, body').animate({
            scrollTop: jQuery('.shortcodeDisplay').offset().top - adminBar
        }, 1000);
    }
    jQuery('.shortcodeCopyButton').click(function (e) {
        e.preventDefault();
        target = jQuery(this).attr('data-target');
        if (target != "") {
            codeCopy(target);
        }
    });



    if (jQuery("#brodos_article_link_submit").length) {
        jQuery("#brodos_article_link_submit").click(function (e) {
            e.preventDefault();
            var link = jQuery("#brodos_article_link_url").val();
            var brodosUrl = jQuery("input[name='global_brodos_url']").val();
            if (isUrlValid(link)) {
                linkArr = link.split('/');
                if (linkArr.indexOf('artikel') != -1) {
                    pos = linkArr.indexOf('artikel') + 1;
                    searchTerm = linkArr[pos];
                    var countAPILink = brodosUrl + '/api/v1/get_article?num=' + searchTerm;
                    jQuery.ajax({
                        url: countAPILink,
                        dataType: 'json',
                        type: 'GET',
                        crossDomain: true,
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function (data) {
                            aAvailable = data['available'];
                            if (aAvailable == true) {
                                var aName = data['title'];
                                var aImage = data['image'];
                                var aPrice = data['price'];
                                var aUrl = data['link'];
                                var exampleHtml = '<article class="articlePreviewDisplay">';
                                exampleHtml += '<a href="' + aUrl + '">';
                                exampleHtml += '<img src="' + aImage + '" alt />';
                                exampleHtml += '</a>';
                                exampleHtml += '<a href="' + aUrl + '">';
                                exampleHtml += aName;
                                exampleHtml += '</a>';
                                exampleHtml += '<p class="price">' + aPrice + '</p>';
                                exampleHtml += '</article>';
                                jQuery("#brodos_article_link_display").html(exampleHtml);
                            } else {
                                var exampleHtml = '<div class="notice notice-error is-dismissible"><p>This article is not available.</p></div>';
                                jQuery("#brodos_article_link_display").html(exampleHtml);
                            }
                            /* Scroll to preview */
                            adminBar = 0;
                            if (jQuery('#wpadminbar').length) {
                                adminBar = jQuery('#wpadminbar').outerHeight(true);
                            }
                            jQuery('html, body').animate({
                                scrollTop: jQuery('#brodos_article_link_display').offset().top - adminBar
                            }, 1000);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.error("There was a problem with get_article API.");
                        }
                    });
                } else {
                    console.error("Please enter valid article URL.");
                }
            } else {
                console.error("There was a problem with get_article API.");
            }
        });
    }
});
function codeCopy(elementId) {
    var Elem = document.createElement("input");
    Elem.setAttribute("value", document.getElementById(elementId).innerHTML);
    document.body.appendChild(Elem);
    Elem.select();
    document.execCommand("copy");
    document.body.removeChild(Elem);
}
function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}