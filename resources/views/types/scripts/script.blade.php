<script>
    $('#addForm').on('submit', function () {
        e.preventDefault();

        $.ajax({
            type:"POST",
            url: "sections.store",
            data: $('#addForm').serialize(),
            success: function (response) {
                console.log(response);
                $('#modaldemo8').modal('hide');
                alert("Success");
            },
            error: function (error) {
                console.log(error);
            };
        })
    }
</script>
