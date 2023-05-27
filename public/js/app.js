/**
 * @file
 * 
 * This file will handle ajax requests, dom events, etc.
 */

//CSRF-TOKEN for AJAX Requests.
var _token = $('meta[name=csrf-token]').attr('content');

$(document).ready(function () {
    //Initialize all the components of materialize css
    M.AutoInit();

    /**
     * Navigate to the function definition
     * for details.
     */
    stickyNavbar();

    carousalSlider();
    mobileSearch();
    navSearch();
    addToCart();
    addToWishlist();
    updateCart();
});

/**
 * get the dropdown instances
 * and make constrain width to
 * false.
 */
function autoWidthDropDown() {
    var dropdowns = document.querySelectorAll('.no-constrain');
    M.Dropdown.init(dropdowns, {
        constrainWidth: false
    });
}

/**
 * Make the carousal slider
 * slide automatically with a
 * timeout of 3500 milliseconds.
 */
function carousalSlider() {
    /**
     *  If we have the carousel element,
     *  then we want to execute this code.
     */
    if (document.querySelector('.carousel')) {
        var carousel = document.querySelector('.carousel');
        M.Carousel.init(carousel, {
            indicators: true,
            fullWidth: true
        });
        var slider = M.Carousel.getInstance(carousel);
        setInterval(function () {
            slider.next(1);
        }, 3500);
    }
}

/**
 * Hide the navbar on scroll up
 * and show on scroll down.
 */
function stickyNavbar() {
    //only if we have a navbar with id of navbar
    if($('#navbar').get(0)){
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function () {
            var navbar = $('#navbar').get(0);
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                navbar.style.top = "0";
            }
            else {
                navbar.style.top = "-65px";
            }
            prevScrollpos = currentScrollPos;
        };
    }
}

/**
 * Handle search functionality on
 * small devices.
 */
function mobileSearch() {
    //Search box element
    var mobileSearch = $('#mobile-search');

    //Close icon element on search box
    var closeIcon = $('.close-icon-mb');
    
    //when close icon on search box is click.
    $('#search-close-mb').click(function (e) {
        e.preventDefault();
        $('#search-results-mb').hide();
        mobileSearch.val('');
    });

    searchFocusBlur(mobileSearch, closeIcon);

    //Handle the actual search functionality.
    search(
        mobileSearch,
        $('#search-results-mb').get(0),
        searchResult
    );

    var searchIcon = $('#search-icon-mb');
    var searchForm = $('#search-form-mb');

    submitSearch( searchIcon, searchForm, mobileSearch);
}

/**
 * Handle search functionality on
 * large screens.
 */
function navSearch(){
    //Search box element.
    var Search = $('#search');
    
    //Close icon element on the search box.
    var closeIcon = $('.close-icon');

    //when close icon on search box is click.
    $('#search-close').click(function(e){
        e.preventDefault();
        //hide the search results element.
        $('#search-results').hide();
        //clear the search box.
        Search.val('');
    });

    searchFocusBlur(Search, closeIcon);

    //Handle the actual search functionality.
    search(
        Search,
        $('#search-results').get(0),
        searchResult
    );

    var searchIcon = $('#search-icon');
    var searchForm = $('#search-form');

    submitSearch( searchIcon, searchForm, Search);
}

/**
 * Submit the Search form instead of
 * making an AJAX request.
 * 
 * @param {*} searchIcon 
 * @param {*} searchForm 
 * @param {*} Search 
 */
function submitSearch( searchIcon, searchForm, Search) {
    searchIcon.click(function (e) {
        e.preventDefault();

        //if search box is not empty
        if (Search.val() != '') {
            searchForm.submit();
        }
    });
}

/**
 * When Search box has gained or lost focus.
 * (Both small and large devices)
 * 
 * @param {*} Search 
 * @param {*} closeIcon 
 */
function searchFocusBlur(Search, closeIcon) {
    Search.focus(function () {
        closeIcon.addClass('grey-text');
        closeIcon.removeClass('transparent-text');
        closeIcon.css('opacity', '1');
    });
    Search.blur(function () {
        closeIcon.css('opacity', '0');
    });
}

/**
 * Handle Search with AJAX request.
 * 
 * @param {*} elID 
 * @param {*} resElID 
 * @param {*} successCallback  
 */
function search(elID, resElID, successCallback) {
    elID.on('keyup input propertychange', function () {
        var str = $(this).val();
        if (str.length <= 1) {
            resElID.style.display = "";
        }
        else {
            makeAJAXRequest(
                '/search/' + str,
                'GET',
                null,
                function (res) {
                    successCallback(res,resElID,str);
                }
            );
        }
    });
}

/**
 * Handle successful ajax request callback.
 * 
 * @param {*} res
 * @param {*} resElID
 * @param {*} search
 */
function searchResult(res, resElID,search) {
    if (res.products.length != 0) {
        var products = res.products;
        resElID.innerHTML = "";
        resElID.style.display = 'block';
        for (var i in products) {
            resElID.innerHTML += `
                <a href="/products/${products[i].slug}" class="truncae grey-text text-darken-1 collection-item">
                    ${products[i].title}
                </a>`;
        }
        resElID.innerHTML +=`
            <a href="/search?search=`+search+`" class="collection-item center">
                Show all results
            </a>
        `;
    }else{
        resElID.innerHTML = "";
        resElID.innerHTML = `
            <a href="#" class="collection-item grey-text text-darken-2">
                Nothing found!
            </a>
        `;
    }
}

/**
 * Handle Add to Cart AJAX Request.
 */
function addToCart(){
    $('body').delegate('.add-cart', 'click', function (e) {
        // get the attribute value of element with #add-cart id.
        var id = $(this).attr('data-id');

        // get the text (value) of selected quantity
        var qty = $('#qty :selected').text();
        
        if (!qty) {
            qty = 1;
        }

        var data = {
            _token: _token,
            _id: id,
            _qty: qty
        };

        //prevent form submission
        e.preventDefault();

        //Make ajax request to a specific url
        makeAJAXRequest(
            '/cart/add',
            'POST',
            data,
            function (res) {
                addCartSuccess(res)
            },
            function(res){
                if(res.status == 422){
                    makeToast("Invalid product please refresh the page!");
                }
            }
        )
    })
}

/**
 * Handle AJAX request for updating
 * the cart.
 */
function updateCart(){
    $('body').delegate('.update-cart', 'click', function (e) {
        e.preventDefault();
        
        // "this" means the current object, in our case
        // it's #update-cart.
        var id = $(this).attr('data-id');
        var qty = $('#qty-'+id).val() || 0 ;
        var rowId = $('#rowId-' + id).val();

        var data = {
            _token: _token,
            _rowId: rowId,
            _qty: qty
        };

        makeAJAXRequest(
            '/cart/update',
            'POST',
            data,
            function (res) {
                updateCartSuccess(res, id)
            },
            function(res){
                validationFailed(res.status,"Invalid product please refresh the page!");
            }
        );
    });
}

/**
 * callback function for successful
 * ajax request for updating cart item. 
 * 
 * @param {*} res 
 * @param {*} id 
 */
function updateCartSuccess(res, id) {
    //update the cart-subtotal
    $('.cart-subtotal').text('$' + res.subtotal + ' /-');

    //update the cart-tax
    $('.cart-tax').text('$' + res.tax + ' /-');

    //update the cart-total
    $('.cart-total').text('$' + res.total + ' /-');

    //Cart Count
    var cartTotal = res.cart_count;

    // if an item was deleted from cart
    if (res.type === 'delete') {
        /** 
         * add css classes before removing the element.
         * so it has a nice animation to it.
         */
        $('tr[data-id=' + id + ']').addClass('animated fadeOut');

        setTimeout(function () {
            $('tr[data-id=' + id + ']').on('transitionend', function (e) {
                $(this).remove();
            });
            if (cartTotal === 0) {
                $('.checkout-btn').addClass('disabled');
                $('.cart-items')
                    .remove();

                $('.cart-panel')
                    .html(`<h5 class="animated fadeIn grey-text text-darken-2 center">Your cart is empty! <a href="/products"> Start Shopping</a></h5>`);
            }
        }, 300);
    }
    
    makeToast(res.msg);

    updateCartTotal(cartTotal);
}


/**
 * callback function for successful
 * ajax request for adding cart item.
 * 
 * @param {*} res 
 */
function addCartSuccess(res) {
    var msg = `${res.msg}  <a href="/cart" class="btn-flat blue-text"> Cart</a>`;
    makeToast(msg);
    updateCartTotal(res.cart_count);
}

/**
 * Update Cart Total
 * 
 * @param {*} cartTotal 
 */
function updateCartTotal(cartTotal) {
    $('.cart-count').text(`(${cartTotal})`);
}

/**
 * Handle AJAX request for adding
 * products to wishlist.
 */
function addToWishlist(){
    // Handle add product to wishlist request
    $('body').delegate('.add-wishlist', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var data = {
            _token: _token,
            _id: id
        };

        makeAJAXRequest(
            '/wishlist/add',
            'POST',
            data,
            function (res) {
                var msg = `${res.message} <a href="/wishlist" class="btn-flat blue-text">Wishlist</a>`;
                makeToast(msg);
            },
            function(res){
                /**
                 * response status 401 means
                 * that we are unauthenticated.
                 */
                if (res.status == 401) {
                    makeToast("Please Login or Register to use Wishlist");
                }
                validationFailed(res.status,"Invalid product please refresh the page!");
            }
        );
    })
}

/**
 * Validatation Failed when making
 * an AJAX request.
 * 
 * @param {*} status 
 * @param {*} msg 
 */
function validationFailed(status,msg){
    /**
     * validation Failed
     */
    if(status == 422){
        makeToast(msg);
    }
}

/**
 * Make ajax request
 * 
 * @param {*} url 
 * @param {*} method 
 * @param {*} data 
 * @param {*} success 
 * @param {*} error
 */
function makeAJAXRequest(url, method, data, success, error) {
    $.ajax({
        method: method,
        dataType: 'json',
        url: url,
        data: data,
        success: success,
        error: error
    });
}

/**
 * Make a toast message
 * 
 * @param {*} msg 
 */
function makeToast(msg) {
    M.toast({
        html: `<span>` + msg + `</span><button class='btn-flat toast-action' onclick='dismissToast()'><i class='material-icons yellow-text'>close</i></button>`,
        inDuration: 500,
        outDuration: 1000
    });
}

/**
 *  Dismiss the Toast on click
 */
function dismissToast() {
    var toastElement = document.querySelector('.toast');
    var toastInstance = M.Toast.getInstance(toastElement);
    toastInstance.dismiss();
}