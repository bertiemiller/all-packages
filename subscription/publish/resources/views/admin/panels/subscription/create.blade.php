@extends( $masterView )

@section('title', 'Welcome to Topic Mine Subscription')
@section('metaDescription', 'Welcome to Topic Mine Subscription')
{{--@section('h1', 'Your Monthly Subsription')--}}

@section('after-head-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
@endsection

@section('content')
    <div class="panel-heading h1-panel">
        <h1>Your Monthly Subsription'</h1>
    </div>
    <div class="panel-body">
        <div class="box">
            <div class="box-body">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                        @if( ! ( isset($data['subscribedTo']) && $data['subscribedTo'] == config('admin.stripe_plan_name') ) )
                            <form novalidate autocomplete="on" method="POST"
                                  action="{{ route(core()->routeStoreName()) }}"
                                  id="payment-form" class="form-horizontal">
                        @else
                            <form novalidate autocomplete="on" method="POST"
                                  action="{{ route(core()->routeUpdateName(), $data['subscriptionId']) }}"
                                  id="payment-form" class="form-horizontal">
                                <input type="hidden" name="_method" value="PATCH">
                        @endif
                            {{ csrf_field() }}

                            @include('admin.panels.subscription._subscription_form')

                            <tr>
                                <td>
                                    <span class="payment-errors"></span>

                                    <div class="form-group">
                                        <span class="col-md-4 control-label"></span>
                                        <div class="col-md-6">
                                            @if( ! ( isset($data['subscribedTo']) && $data['subscribedTo'] == config('admin.stripe_plan_name') ) )
                                                <div class="payment_button">
                                                    <script src="https://checkout.stripe.com/checkout.js"></script>
                                                    <button id="customButton" class="btn btn-lg btn-primary">Pay Now</button>
                                                    <script>
                                                        var handler = StripeCheckout.configure({
                                                            key: '{{env('STRIPE_KEY')}}',
                                                            image: '/img/documentation/checkout/marketplace.png',
                                                            locale: 'auto',
                                                            token: function (token, args) {
                                                                console.log(args);
                                                                console.log(token);
                                                                var $form = $('#payment-form');
                                                                $form.append($('<input type="hidden" name="stripeToken">').val(token.id));
                                                                $form.append($('<input type="hidden" name="billing_name">').val(args.billing_name));
                                                                $form.append($('<input type="hidden" name="address1">').val(args.billing_address_line1));
                                                                $form.append($('<input type="hidden" name="postcode">').val(args.billing_address_zip));
                                                                $form.append($('<input type="hidden" name="town">').val(args.billing_address_city));
                                                                $form.append($('<input type="hidden" name="country">').val(args.billing_address_country));
                                                                $form.get(0).submit();
                                                            }
                                                        });

                                                        $('#customButton').on('click', function (e) {
                                                            // Open Checkout with further options:
                                                            handler.open({
                                                                name: 'Topic Mine',
                                                                email: '{{ $user->email }}',
                                                                description: 'Main Subscription',
                                                                billingAddress: 'true',
                                                                allowRememberMe: 'false',
                                                                locale: 'auto'
                                                            });
                                                            e.preventDefault();
                                                        });

                                                        // Close Checkout on page navigation:
                                                        $(window).on('popstate', function () {
                                                            handler.close();
                                                        });
                                                    </script>
                                                </div>
                                            @endif
                                            <div class="register_button">
                                                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if( ! ( isset($data['subscribedTo']) && $data['subscribedTo'] == config('admin.stripe_plan_name') ) )
        <script>
            function showHideStripe(topics, domains) {

                if (topics == 10 && domains == 1) {
                    $('.register_button').removeClass('hide');
                    $('.payment_button').addClass('hide');
                } else {
                    $('.register_button').addClass('hide');
                    $('.payment_button').removeClass('hide');
                }
                return false;
            }

            var topics = document.getElementById("payment-form").elements["topics"].value
            var domains = document.getElementById("payment-form").elements["domains"].value
            showHideStripe(topics, domains);

            $(function () {
                var $form = $('#payment-form');

                $("#payment-form select").change(function () {
//                    alert('showHide');
                    var values = {};
                    $.each($('#payment-form').serializeArray(), function (i, field) {
                        values[field.name] = field.value;
                    });
                    showHideStripe(values.topics, values.domains);
                });
            });
        </script>
    @endif
@endsection


