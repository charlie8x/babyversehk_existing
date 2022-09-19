jQuery(document).ready(function() {
    jQuery('.zoo-list-cw-attribute .zoo-filter-item').attr('data-toggle', 'tooltip');
    jQuery('.zoo-list-cw-attribute .zoo-filter-item').attr('data-placement', 'top');
    jQuery('[data-toggle="tooltip"]').tooltip({
        position: {
            my: "center bottom-10", // the "anchor point" in the tooltip element
            at: "center top", // the position of that anchor point relative to selected element
        }
    });
    jQuery(document).on("click",".zoo-filter-item",function() {
        jQuery('.zoo-list-cw-attribute .zoo-filter-item').attr('data-toggle', 'tooltip');
        jQuery('.zoo-list-cw-attribute .zoo-filter-item').attr('data-placement', 'top');
    });


    // Variable product option
      jQuery('#pa_size').on('change', function(ev) {
        ev.preventDefault();
        if(this.value == ''){
          jQuery(".single_add_to_cart_button span").text('Add To cart');
          jQuery(".zoo-cw-attr-row div span").html('');
        return false;
      }
    }); 
});

