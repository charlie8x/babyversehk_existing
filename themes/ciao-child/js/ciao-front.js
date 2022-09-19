jQuery('#paycut_brand').change(function() {
    jQuery('#paycut_cat').removeAttr('disabled');
    jQuery('#paycut_submit').removeAttr('disabled');
 });
 
jQuery("#filter_paycut").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var filter = jQuery(this);
    jQuery.ajax({
        url:filter.attr('action'),
        data:filter.serialize(), // form data
        type:filter.attr('method'), // POST
        beforeSend:function(xhr){
            filter.find('button').text('Processing...'); // changing the button label
        },
        success:function(data){
            console.log(data);
            filter.find('button').text('Calculate'); // changing the button label back
            jQuery('#response').html(data); // insert data
        }
    });
    return false;
});