$(document).ready(function(){
    var $collectionHolder;

// setup an "add a tag" link
    var $addEmailInput =  $('.create_event_form .email_input');
    var $addEmailButton = $('.create_event_form .email_add');
    var $removeEmailButton = $('<div class="remove_email glyphicon glyphicon-minus"></div>')
    //var $removeRowButton = $('<span class="remove_email"></span>');
    //var $emailRow = $('<div></div>').append($removeRowButton);

    var ROUNDING = 30 * 60 * 1000; /*ms*/
    start = moment();
    start = moment(Math.ceil((+start) / ROUNDING) * ROUNDING);
    jQuery(document).ready(function() {
        $('#time_input').datetimepicker({
            locale: 'en',
            format: 'YYYY-MM-DD HH:mm',
            minDate: start,
            stepping: 30
        });
        // Get the ul that holds the collection of tags
        $collectionHolder = $('div.email_list');


        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder.data('index', $collectionHolder.find(':input').length);
        // renderEmails($collectionHolder);
        $addEmailButton.click(function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // add a new tag form (see next code block)
            addEmailForm($collectionHolder);
            renderEmails($collectionHolder);
        });
    });
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    function addEmailForm($collectionHolder) {
        var value = $addEmailInput.val()
        if( value != '' && isEmail(value) ){
            // Get the data-prototype explained earlier
            var prototype = $collectionHolder.data('prototype');

            // get the new index
            var index = $collectionHolder.data('index');

            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            var newForm = $.parseHTML(prototype.replace(/__name__/g, index));
            $(newForm).val(($addEmailInput.val()));

            // increase the index with one for         the next item
            $collectionHolder.data('index', index + 1);

            // Display the form in the page in an li, before the "Add a tag" link li

            $collectionHolder.append(newForm);
            $collectionHolder.append($('<div class="email_row"></div>').text($addEmailInput.val()).append($removeEmailButton.clone()));

            $('.remove_email').click(function(){
                var value = $(this).parent().text();
                $(this).parent().find('input[value="' + value +'"]').remove();
                $(this).parent().remove();
            });
            $addEmailInput.val('');
        }
    }
    function renderEmails($collectionHolder){
        $collectionHolder.find(':input').each( function (){
            $collectionHolder.append($('<div class="email_row"></div>').text($addEmailInput.val()));
        });
    }
});
