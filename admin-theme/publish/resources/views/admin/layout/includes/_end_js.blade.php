<!-- JavaScripts -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>--}}
<script src="/admin-theme/js/vendor/jquery/jquery-2.1.4.min.js"></script>
<script>window.jQuery || document.write('<script src="{{asset('admin-theme/js/vendor/jquery/jquery-2.1.4.min.js')}}"><\/script>')</script>
{!! Html::script('admin-theme/js/vendor/bootstrap/bootstrap.min.js') !!}

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.js" charset="utf-8"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>--}}


@yield('before-scripts-end')
{!! HTML::script(elixir('admin-theme/js/admin-layout.js')) !!}
@yield('after-scripts-end')

<script>
    $(document).ready(function () {
        $('[data-toggle="offcanvas"]').click(function (e) {
            var icon = $(this).parent().find("i.fa-collapse")
            var label = $(this).parent().find("i.fa-collapse span");
            if (icon.hasClass('fa-arrow-circle-right')) {
                icon.removeClass('fa-arrow-circle-right').addClass("fa-arrow-circle-left");
                label.html('Collapse Menu');
            } else {
                icon.removeClass('fa-arrow-circle-left').addClass("fa-arrow-circle-right");
                label.html('Expand Menu');
            }
        });
    });

    $(document).on("click", ".content-wrapper, .content-wrapper *, .main-footer, .main-footer *", function (e) {

        if ($(".control-sidebar").hasClass('control-sidebar-open')) {
            $('#controlToggleButton').trigger("click");
        }

        console.log(this);
        e.stopPropagation();
    });

</script>

<script>
    $('#flash-overlay-modal').modal();
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>


