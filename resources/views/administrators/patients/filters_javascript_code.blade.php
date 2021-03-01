<script type="text/javascript">

    function destroy_patient(form_id){
        if (confirm('{{ trans("forms.confirm") }}')) {
            var form = document.getElementById('destroy_patient_'+form_id);
            form.submit();
        }
    }

    function load(page) {
        $("#page" ).val(page);
        document.all["select_page"].submit();
    }

    $(document).ready(function() {
        // Put the filter
        $("#filter" ).val('{{ $request->filter ?? '' }}');

        // Check a type
        $('input:radio[name="type"][value="{{ $request->type ?? '' }}"]').prop('checked', true);
    });
</script>
