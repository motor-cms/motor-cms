{!! form_start($form) !!}
{!! form_row($form->headline) !!}
{!! form_row($form->body) !!}
{!! form_end($form) !!}
<script type="text/javascript">
    console.log("AJAX inserted JS is working!");
    $('form').on('submit', function (e) {
        e.preventDefault();

        console.log("Form SUBMIT");

        $.ajax({
            method: "POST",
            data: $(this).serialize(),
            url: $(this).attr('action')
        }).done(function (response) {
            console.log(response);
        });
    });
</script>