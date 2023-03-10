<script src="{{ url(mix('js/libs.js')) }}" type="text/javascript"></script>
<script src="{{ asset('js/metisMenu.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lcrm_app.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/secure.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/icheck.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lobibox.min.js') }}"></script>
<script src="{{ asset('js/datatables_app.js') }}"></script>
@yield('scripts')
<script type="text/javascript">
    $(document).ready(function(){
       $(".repeater").repeater({
           defaultValues: {
               "textarea-input": "foo",
               "text-input": "bar",
               "select-input": "B",
               "checkbox-input": ["A", "B"],
               "radio-input": "B",
           },
           show: function () {
               $(this).slideDown();
           },
           hide: function (e) {
               confirm("Are you sure you want to delete this element?") && $(this).slideUp(e);
           },
           ready: function (e) {
             // $(".select2").select2();
           },

       });
       $("#repeater-button").click(function(){
          setTimeout(function(){
            $(".select2").select2();
          }, 100);
        });

     });
</script>
