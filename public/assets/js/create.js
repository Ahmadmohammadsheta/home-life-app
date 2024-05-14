


//-----------------------------------------------------------------------------------------------------------
// AMA. related product section ajax
// working
$(document).ready(function() {
    var categoryId = $('input[name="id"]').val();
    if (categoryId) {
        $.ajax({
            url: "{{ URL::to('categories/') }}/" + categoryId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                // alert(data.category);
                $('select[name="parent_id"]').empty();

                $('select[name="parent_id"]').append('<option value="' +
                data.category.id + '">' + data.category.name + '</option>');

                $('select[name="type_id"]').empty();

                $('select[name="type_id"]').append('<option value="' +
                data.category.type.id + '">' + data.category.type.name + '</option>');
            },
        });

    } else {
        console.log('AJAX load did not work');
    }

});
//__________________________________________________________________________________________________________

//-----------------------------------------------------------------------------------------------------------
// AMA. related product section ajax
// working
$(document).ready(function() {
    $('select[name="parent_id"]').on('change', function() {
        var parentId = $(this).val();
        if (parentId) {
            $.ajax({
                url: "{{ URL::to('categories/') }}/" + parentId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="type_id"]').empty();
                    // $.each(data, function(index, value) {
                        // alert(data.data.id);
                        $('select[name="type_id"]').append('<option value="' +
                        data.type.id + '">' + data.type.name + '</option>');
                    // });
                },
            });

        } else {
            console.log('AJAX load did not work');
        }
    });

});
//__________________________________________________________________________________________________________

