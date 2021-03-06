
var $collectionHolder;

// setup an "add order" link
var $newLinkLi = $('<li class="list-group-item" >Total:</li>');

jQuery(document).ready(function() {
    registerOnClicks();
    // Get the ul that holds the collection of orders
    $collectionHolder = $('ul.orders');
    calculateTotalPrice();
    // add a delete link to all of the existing orders form li elements
    $collectionHolder.find('li').each(function() {
        addOrderFormDeleteLink($(this));
    });

    // add the "add order" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $('.add-dish').on('click', function(e) {
        var $dish_id = $(this).attr('data-id');
        var $existing_dih_on_cart = false;
        $collectionHolder.find('li').each(function () {
            var $input_val = $(this).find("input").val();

            if ($input_val == $dish_id) {
                $existing_dih_on_cart = true;
            }
        });

        if ($existing_dih_on_cart == false) {
            var $amount = $(this).siblings("input[name='quantity']").first().val();

            if ($amount > 0 && $amount < 1000) {
                var $parent = $(this).parent();
                var $dish_name = $parent.siblings(".dish_name").text();
                var $price = parseFloat($parent.siblings(".price").text());

                // add a new tag form (see next code block)
                addOrderForm($collectionHolder, $newLinkLi, $dish_id, $amount, $dish_name, $price);
            }
        }
        calculateTotalPrice();
    });

});

function addOrderForm($collectionHolder, $newLinkLi, $dish_id, $amount, $dish_name, $price ) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype
            .replace(/__name__/g, index)
            .replace(/__idvalue__/g, $dish_id)
            .replace(/__qvalue__/g, $amount)
        +"<b>" +  $dish_name + "</b> <br> Amount:<button class='minus btn btn-default btn-xs'>-</button> <span>"
        + $amount
        + "</span>   <button class='plus btn btn-default btn-xs'>+</button> <br> Price: <p class='price'>"+
        ($price*$amount).toFixed(2) +"</p> €";

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li class="list-group-item" ></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addOrderFormDeleteLink($newFormLi);
    registerOnClicks();
}

function addOrderFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<button class="btn btn-danger" style="float:right;">-</button>');
    $tagFormLi.prepend($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
        calculateTotalPrice();
    });
}

function calculateTotalPrice(){
    var $sum  = 0;
    $collectionHolder = $('ul.orders');
    $collectionHolder.find('li').each(function () {
        var $price_val = parseFloat($(this).find(".price").first().text());
        if(!isNaN($price_val))
            $sum += $price_val;
    });
    $newLinkLi.text("Total: " + $sum.toFixed(2) + " €");
}

function registerOnClicks(){


    $('button.plus').unbind().click(function(event){
        event.preventDefault();
        var $amount = parseFloat($(this).siblings("span").eq(0).text());
        console.log($amount + $(this).siblings("b").text());
        if($amount<100) {
            var $price = parseFloat($(this).siblings(".price").text());

            var $pricePerOne = $price / $amount;

            $(this).siblings(".price").text(($price + $pricePerOne).toFixed(2));
            $(this).siblings("span").text($amount + 1);
            $(this).siblings("input").eq(1).val($amount+1);
        }
        calculateTotalPrice();
    });

    $('button.minus').unbind().click(function(event){
        event.preventDefault();
        var $amount = parseFloat($(this).siblings("span").text());

        if($amount>1){
            var $price = parseFloat($(this).siblings(".price").text());
            var $pricePerOne = $price / $amount;
            $(this).siblings(".price").text(($price - $pricePerOne).toFixed(2));
            $(this).siblings("span").text($amount - 1);
            $(this).siblings("input").eq(1).val($amount-1);
        }
        calculateTotalPrice();
    });
}