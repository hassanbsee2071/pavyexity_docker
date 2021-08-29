@extends('auth.layouts.auth')

@section('body_class','bg-white')

@section('content')
<div>
@if(Session::has('errorMessage'))
    <div class="modal show" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Error</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>{{Session::get('errorMessage')}}</p>
        </div>
        </div>
    </div>
    </div>
    @endif
    <!-- <div class="row">
        @if(Session::has('errorMessage'))
        <p class="alert alert-danger alert-block">{{ Session::get('errorMessage') }}</p>
        @endif
        @if(Session::has('successMessage'))
        <p class="alert alert-success alert-block">{{ Session::get('successMessage') }}</p>
        @endif
    </div> -->
    {{ Form::open(['route'=>['admin.payments.proccess-payment'],'method' => 'post','class'=>'form-horizontal form-label-left','name'=>'frm_payment_method']) }}
    <div class="App-Container is-noBackground flex-container justify-content-center">
        <div class="App App--singleItem">
            <div class="App-Overview">
                <header class="Header" style="background-color: rgb(255, 255, 255);">
                    <div class="Header-Content flex-container justify-content-space-between align-items-stretch">
                        <div class="Header-business flex-item width-grow flex-container align-items-center"><a
                                class="Link Header-businessLink Link--primary"
                                href="https://demo.wpsimplepay.com/payment-failed/" aria-label="Previous page"
                                target="_self">
                                <div style="position: relative;">
                                    <div class="flex-container align-items-center">
                                        <div class="Header-backArrowContainer" style="opacity: 1; transform: none;"><svg
                                                class="InlineSVG Icon Header-backArrow mr2 Icon--sm" focusable="false"
                                                width="12" height="12" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.417 7H15a1 1 0 0 1 0 2H3.417l4.591 4.591a1 1 0 0 1-1.415 1.416l-6.3-6.3a1 1 0 0 1 0-1.414l6.3-6.3A1 1 0 0 1 8.008 2.41z"
                                                    fill-rule="evenodd"></path>
                                            </svg></div>
                                        <div class="Header-merchantLogoContainer" style="transform: none;">
                                            <div class="Header-merchantLogoWithLabel flex-item width-grow">
                                                <div
                                                    class="HeaderImage HeaderImage--icon HeaderImage--iconFallback flex-item width-fixed flex-container justify-content-center align-items-center width-fixed">
                                                    <svg class="InlineSVG Icon HeaderImage-fallbackIcon Icon--sm"
                                                        focusable="false" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3 7.5V12h10V7.5c.718 0 1.398-.168 2-.468V15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7.032c.602.3 1.282.468 2 .468zM0 3L1.703.445A1 1 0 0 1 2.535 0h10.93a1 1 0 0 1 .832.445L16 3a3 3 0 0 1-5.5 1.659C9.963 5.467 9.043 6 8 6s-1.963-.533-2.5-1.341A3 3 0 0 1 0 3z"
                                                            fill-rule="evenodd"></path>
                                                    </svg></div><span
                                                    class="Header-businessLink-label Text Text-color--gray800 Text-fontSize--14 Text-fontWeight--500">Back</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div></div>
                </header>
                <div class="">
                    <div class="ProductSummary">
                        <div class="ProductSummary-info select">
                            <select id="payment_method" class="Select-source w-100 col-md-7 col-xs-12 @if($errors->has('payment_method')) parsley-error @endif" name="payment_method">
                                <option value="">Select payment method</option>
                                <option value="bank_account">Bank Account</option>
                                <option value="credit_card">Credit Card</option>
                            </select>
                            <svg class="InlineSVG Icon Select-arrow Icon--sm" focusable="false" viewBox="0 0 12 12">
                                <path d="M10.193 3.97a.75.75 0 0 1 1.062 1.062L6.53 9.756a.75.75 0 0 1-1.06 0L.745 5.032A.75.75 0 0 1 1.807 3.97L6 8.163l4.193-4.193z" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ProductSummary-info select mt-2" style="margin-top:5px;">
                            <div
                                                class="FormFieldGroup-child FormFieldGroup-child--width-12 FormFieldGroup-childLeft FormFieldGroup-childRight FormFieldGroup-childTop FormFieldGroup-childBottom">
                            <input id="payment_amount" type="payment_amount" class="CheckoutInput Input Input--empty @if($errors->has('payment_amount')) parsley-error @endif" name="payment_amount" placeholder="0.00$" value="{{$Transactions->transaction_amount}}" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="App-Payment">
                <div class="CheckoutPaymentForm">
                    <div class="PaymentRequestOrHeader" style="height: auto;">
                        <div class="ButtonAndDividerContainer" style="opacity: 0; display: none;"></div>
                    </div>
                        <div class="App-Global-Fields flex-container spacing-16 direction-row wrap-wrap">
                            <div class="flex-item width-12">
                                <h2
                                    class="ShippingDetails-Heading Text Text-color--gray800 Text-fontSize--16 Text-fontWeight--500">
                                    Billing information</h2>
                            </div>
                            <div class="ShippingForm flex-item width-12">
                                <div class="FormFieldGroup">
                                </div>
                            </div>
                            <div class="flex-item width-12">
                                <h2
                                    class="PaymentMethod-Heading Text Text-color--gray800 Text-fontSize--16 Text-fontWeight--500">
                                    Payment details</h2>
                            </div>
                        </div>
                        <div id="payment_type_fields">

                        </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

    <div style="display:none" id="bank_account" class="App-Global-Fields flex-container spacing-16 direction-row wrap-wrap">
                            <div class="flex-item width-12">
                                <h2
                                    class="ShippingDetails-Heading Text Text-color--gray800 Text-fontSize--16 Text-fontWeight--500">
                                    Bank information</h2>
                            </div>
                            <div class="flex-item width-12">
                                <div class="FormFieldGroup">
                                    <div class="FormFieldGroup-Fieldset" id="email-fieldset">
                                        <div class="FormFieldGroup-container">
                                            <div
                                                class="FormFieldGroup-child FormFieldGroup-child--width-12 FormFieldGroup-childLeft FormFieldGroup-childRight FormFieldGroup-childTop FormFieldGroup-childBottom">
                                                <div class="FormFieldInput"><span class="InputContainer"
                                                        data-max=""><input class="CheckoutInput Input Input--empty @if($errors->has('account_number')) parsley-error @endif" name="account_number" placeholder="Enter bank account number"
                                                        id="account_number" onkeyup="account(this)" type="text"></span></div>
                                            </div>
                                            <div style="opacity: 0; height: 0px;"><span
                                                    class="FieldError Text Text-color--red Text-fontSize--13"><span
                                                        aria-hidden="true"></span></span></div>
                                                        <div
                                                class="FormFieldGroup-child FormFieldGroup-child--width-12 FormFieldGroup-childLeft FormFieldGroup-childRight FormFieldGroup-childTop FormFieldGroup-childBottom">
                                                <div class="FormFieldInput"><span class="InputContainer"
                                                        data-max=""><input class="CheckoutInput Input Input--empty @if($errors->has('routing_number')) parsley-error @endif" id="routing_number" onkeyup="routing(this)" type="number" name="routing_number" placeholder="Enter bank routing number"></span></div>
                                            </div>
                                            <div
                                                class="FormFieldGroup-child FormFieldGroup-child--width-12 FormFieldGroup-childLeft FormFieldGroup-childRight FormFieldGroup-childTop FormFieldGroup-childBottom">
                                                <div class="FormFieldInput is-select"><span class="InputContainer"
                                                        data-max="">
                                                        <div class="Select">
                                                        <select id="account_type" class="form-control col-md-7 col-xs-12 @if($errors->has('account_type')) parsley-error @endif" name="account_type">
                                                            <option value="">Select account type </option>
                                                            <option value="1">Checking</option>
                                                            <option value="2">Savings</option>
                                                        </select>
                                                        </div>
                                                    </span></div>
                                                </div>
                                            </div>
                                        <div style="opacity: 0; height: 0px;"><span
                                                class="FieldError Text Text-color--red Text-fontSize--13"><span
                                                    aria-hidden="true"></span></span></div>
                                    </div>
                                    <div class="flex-item width-12"><button id='btnPay' class="SubmitButton SubmitButton--incomplete"
                                    type="submit"
                                    style="background-color: rgb(36, 103, 182); color: rgb(255, 255, 255);">
                                    <div class="SubmitButton-Shimmer"
                                        style="background: linear-gradient(to right, rgba(36, 103, 182, 0) 0%, rgb(68, 125, 207) 50%, rgba(36, 103, 182, 0) 100%);">
                                    </div>
                                    <div class="SubmitButton-TextContainer"><span
                                            class="SubmitButton-Text SubmitButton-Text--current Text Text-color--default Text-fontWeight--500 Text--truncate"
                                            aria-hidden="false">Pay US${{$Transactions->transaction_amount}}</span><span
                                            class="SubmitButton-Text SubmitButton-Text--pre Text Text-color--default Text-fontWeight--500 Text--truncate"
                                            aria-hidden="true">Processing...</span></div>
                                    <div class="SubmitButton-IconContainer">
                                        <div class="SubmitButton-Icon SubmitButton-Icon--pre">
                                            <div class="Icon Icon--md Icon--square"><svg viewBox="0 0 16 16"
                                                    xmlns="http://www.w3.org/2000/svg" focusable="false">
                                                    <path
                                                        d="M3 7V5a5 5 0 1 1 10 0v2h.5a1 1 0 0 1 1 1v6a2 2 0 0 1-2 2h-9a2 2 0 0 1-2-2V8a1 1 0 0 1 1-1zm5 2.5a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1zM11 7V5a3 3 0 1 0-6 0v2z"
                                                        fill="#ffffff" fill-rule="evenodd"></path>
                                                </svg></div>
                                        </div>
                                        <div class="SubmitButton-Icon SubmitButton-SpinnerIcon SubmitButton-Icon--pre">
                                            <div class="Icon Icon--md Icon--square"><svg viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg" focusable="false">
                                                    <ellipse cx="12" cy="12" rx="10" ry="10"
                                                        style="stroke: rgb(255, 255, 255);"></ellipse>
                                                </svg></div>
                                        </div>
                                    </div>
                                    <div class="SubmitButton-CheckmarkIcon">
                                        <div class="Icon Icon--md"><svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                height="14" focusable="false">
                                                <path d="M 0.5 6 L 8 13.5 L 21.5 0" fill="transparent" stroke-width="2"
                                                    stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg></div>
                                    </div>
                                </button>
                                <div class="ConfirmPayment-PostSubmit">
                                    <div>
                                        <div class="ConfirmTerms Text Text-color--gray500 Text-fontSize--13">By
                                            confirming your payment, you allow to charge your card
                                            for this payment and future payments in accordance with their terms.</div>
                                    </div>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>
                        <div style="opacity: 0; height: 0px;" id="credit_card" class="PaymentForm-paymentMethodFormContainer flex-container spacing-16 direction-row wrap-wrap">
                            <div class="flex-item width-12">
                                <div class="FormFieldGroup">
                                    <div
                                        class="FormFieldGroup-labelContainer flex-container justify-content-space-between">
                                        <label for="cardNumber-fieldset"><span
                                                class="Text Text-color--gray600 Text-fontSize--13 Text-fontWeight--500">Card
                                                information</span></label></div>
                                    <fieldset class="FormFieldGroup-Fieldset" id="cardNumber-fieldset">
                                        <div class="FormFieldGroup-container" id="cardNumber-fieldset">
                                            <div
                                                class="FormFieldGroup-child FormFieldGroup-child--width-6 FormFieldGroup-childLeft FormFieldGroup-childBottom">
                                                <div class="FormFieldInput"><span class="InputContainer"
                                                        data-max=""><input class="CheckoutInput Input Input--empty"
                                                            autocomplete="shipping name" autocorrect="off"
                                                            spellcheck="false" id="shippingName" name="name"
                                                            type="text" aria-label="Name" placeholder="First name"
                                                            aria-invalid="false" aria-describedby="" value=""></span></div>
                                            </div>
                                            <div style="opacity: 0; height: 0px;"><span
                                                    class="FieldError Text Text-color--red Text-fontSize--13"><span
                                                        aria-hidden="true"></span></span></div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="billing-container flex-item width-12 flex-item-no-padding" aria-hidden="true">
                                <div style="height: 0px; opacity: 0; pointer-events: none;">
                                    <div class="flex-container spacing-16 direction-row wrap-wrap">
                                        <div class="flex-item width-12">
                                            <div class="FormFieldGroup">
                                                <div
                                                    class="FormFieldGroup-labelContainer flex-container justify-content-space-between">
                                                    <label for="billingName"><span
                                                            class="Text Text-color--gray600 Text-fontSize--13 Text-fontWeight--500">Name
                                                            on card</span></label></div>
                                                <div class="FormFieldGroup-Fieldset">
                                                    <div class="FormFieldGroup-container" id="billingName-fieldset">
                                                        <div
                                                            class="FormFieldGroup-child FormFieldGroup-child--width-12 FormFieldGroup-childLeft FormFieldGroup-childRight FormFieldGroup-childTop FormFieldGroup-childBottom">
                                                            <div class="FormFieldInput"><span class="InputContainer"
                                                                    data-max=""><input
                                                                        class="CheckoutInput Input Input--empty"
                                                                        autocomplete="ccname" autocorrect="off"
                                                                        spellcheck="false" id="billingName"
                                                                        name="billingName" disabled="" type="text"
                                                                        aria-invalid="false" value=""></span></div>
                                                        </div>
                                                        <div style="opacity: 0; height: 0px;"><span
                                                                class="FieldError Text Text-color--red Text-fontSize--13"><span
                                                                    aria-hidden="true"></span></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-item width-12">
                                            <div class="FormFieldGroup">
                                                <div
                                                    class="FormFieldGroup-labelContainer flex-container justify-content-space-between">
                                                    <label for="billing-address-fieldset"><span
                                                            class="Text Text-color--gray600 Text-fontSize--13 Text-fontWeight--500">Billing
                                                            address</span></label></div>
                                                <fieldset class="FormFieldGroup-Fieldset" id="billing-address-fieldset">
                                                    <div class="FormFieldGroup-container">
                                                        <div
                                                            class="FormFieldGroup-child FormFieldGroup-child--width-12 FormFieldGroup-childLeft FormFieldGroup-childRight FormFieldGroup-childTop">
                                                            <div class="FormFieldInput is-select">
                                                                <div>
                                                                    <div class="Select"><select id="billingCountry"
                                                                            name="billingCountry"
                                                                            autocomplete="billing country" disabled=""
                                                                            aria-label="Country or region"
                                                                            class="Select-source">
                                                                            <option value="" disabled="" hidden="">
                                                                            </option>
                                                                            <option value="AF">Afghanistan</option>
                                                                            <option value="AX">Åland Islands</option>
                                                                            <option value="AL">Albania</option>
                                                                            <option value="DZ">Algeria</option>
                                                                            <option value="AD">Andorra</option>
                                                                            <option value="AO">Angola</option>
                                                                            <option value="AI">Anguilla</option>
                                                                            <option value="AQ">Antarctica</option>
                                                                            <option value="AG">Antigua &amp; Barbuda
                                                                            </option>
                                                                            <option value="AR">Argentina</option>
                                                                            <option value="AM">Armenia</option>
                                                                            <option value="AW">Aruba</option>
                                                                            <option value="AC">Ascension Island</option>
                                                                            <option value="AU">Australia</option>
                                                                            <option value="AT">Austria</option>
                                                                            <option value="AZ">Azerbaijan</option>
                                                                            <option value="BS">Bahamas</option>
                                                                            <option value="BH">Bahrain</option>
                                                                            <option value="BD">Bangladesh</option>
                                                                            <option value="BB">Barbados</option>
                                                                            <option value="BY">Belarus</option>
                                                                            <option value="BE">Belgium</option>
                                                                            <option value="BZ">Belize</option>
                                                                            <option value="BJ">Benin</option>
                                                                            <option value="BM">Bermuda</option>
                                                                            <option value="BT">Bhutan</option>
                                                                            <option value="BO">Bolivia</option>
                                                                            <option value="BA">Bosnia &amp; Herzegovina
                                                                            </option>
                                                                            <option value="BW">Botswana</option>
                                                                            <option value="BV">Bouvet Island</option>
                                                                            <option value="BR">Brazil</option>
                                                                            <option value="IO">British Indian Ocean
                                                                                Territory</option>
                                                                            <option value="VG">British Virgin Islands
                                                                            </option>
                                                                            <option value="BN">Brunei</option>
                                                                            <option value="BG">Bulgaria</option>
                                                                            <option value="BF">Burkina Faso</option>
                                                                            <option value="BI">Burundi</option>
                                                                            <option value="KH">Cambodia</option>
                                                                            <option value="CM">Cameroon</option>
                                                                            <option value="CA">Canada</option>
                                                                            <option value="CV">Cape Verde</option>
                                                                            <option value="BQ">Caribbean Netherlands
                                                                            </option>
                                                                            <option value="KY">Cayman Islands</option>
                                                                            <option value="CF">Central African Republic
                                                                            </option>
                                                                            <option value="TD">Chad</option>
                                                                            <option value="CL">Chile</option>
                                                                            <option value="CN">China</option>
                                                                            <option value="CO">Colombia</option>
                                                                            <option value="KM">Comoros</option>
                                                                            <option value="CG">Congo - Brazzaville
                                                                            </option>
                                                                            <option value="CD">Congo - Kinshasa</option>
                                                                            <option value="CK">Cook Islands</option>
                                                                            <option value="CR">Costa Rica</option>
                                                                            <option value="CI">Côte d’Ivoire</option>
                                                                            <option value="HR">Croatia</option>
                                                                            <option value="CW">Curaçao</option>
                                                                            <option value="CY">Cyprus</option>
                                                                            <option value="CZ">Czechia</option>
                                                                            <option value="DK">Denmark</option>
                                                                            <option value="DJ">Djibouti</option>
                                                                            <option value="DM">Dominica</option>
                                                                            <option value="DO">Dominican Republic
                                                                            </option>
                                                                            <option value="EC">Ecuador</option>
                                                                            <option value="EG">Egypt</option>
                                                                            <option value="SV">El Salvador</option>
                                                                            <option value="GQ">Equatorial Guinea
                                                                            </option>
                                                                            <option value="ER">Eritrea</option>
                                                                            <option value="EE">Estonia</option>
                                                                            <option value="SZ">Eswatini</option>
                                                                            <option value="ET">Ethiopia</option>
                                                                            <option value="FK">Falkland Islands</option>
                                                                            <option value="FO">Faroe Islands</option>
                                                                            <option value="FJ">Fiji</option>
                                                                            <option value="FI">Finland</option>
                                                                            <option value="FR">France</option>
                                                                            <option value="GF">French Guiana</option>
                                                                            <option value="PF">French Polynesia</option>
                                                                            <option value="TF">French Southern
                                                                                Territories</option>
                                                                            <option value="GA">Gabon</option>
                                                                            <option value="GM">Gambia</option>
                                                                            <option value="GE">Georgia</option>
                                                                            <option value="DE">Germany</option>
                                                                            <option value="GH">Ghana</option>
                                                                            <option value="GI">Gibraltar</option>
                                                                            <option value="GR">Greece</option>
                                                                            <option value="GL">Greenland</option>
                                                                            <option value="GD">Grenada</option>
                                                                            <option value="GP">Guadeloupe</option>
                                                                            <option value="GU">Guam</option>
                                                                            <option value="GT">Guatemala</option>
                                                                            <option value="GG">Guernsey</option>
                                                                            <option value="GN">Guinea</option>
                                                                            <option value="GW">Guinea-Bissau</option>
                                                                            <option value="GY">Guyana</option>
                                                                            <option value="HT">Haiti</option>
                                                                            <option value="HN">Honduras</option>
                                                                            <option value="HK">Hong Kong SAR China
                                                                            </option>
                                                                            <option value="HU">Hungary</option>
                                                                            <option value="IS">Iceland</option>
                                                                            <option value="IN">India</option>
                                                                            <option value="ID">Indonesia</option>
                                                                            <option value="IQ">Iraq</option>
                                                                            <option value="IE">Ireland</option>
                                                                            <option value="IM">Isle of Man</option>
                                                                            <option value="IL">Israel</option>
                                                                            <option value="IT">Italy</option>
                                                                            <option value="JM">Jamaica</option>
                                                                            <option value="JP">Japan</option>
                                                                            <option value="JE">Jersey</option>
                                                                            <option value="JO">Jordan</option>
                                                                            <option value="KZ">Kazakhstan</option>
                                                                            <option value="KE">Kenya</option>
                                                                            <option value="KI">Kiribati</option>
                                                                            <option value="XK">Kosovo</option>
                                                                            <option value="KW">Kuwait</option>
                                                                            <option value="KG">Kyrgyzstan</option>
                                                                            <option value="LA">Laos</option>
                                                                            <option value="LV">Latvia</option>
                                                                            <option value="LB">Lebanon</option>
                                                                            <option value="LS">Lesotho</option>
                                                                            <option value="LR">Liberia</option>
                                                                            <option value="LY">Libya</option>
                                                                            <option value="LI">Liechtenstein</option>
                                                                            <option value="LT">Lithuania</option>
                                                                            <option value="LU">Luxembourg</option>
                                                                            <option value="MO">Macao SAR China</option>
                                                                            <option value="MG">Madagascar</option>
                                                                            <option value="MW">Malawi</option>
                                                                            <option value="MY">Malaysia</option>
                                                                            <option value="MV">Maldives</option>
                                                                            <option value="ML">Mali</option>
                                                                            <option value="MT">Malta</option>
                                                                            <option value="MQ">Martinique</option>
                                                                            <option value="MR">Mauritania</option>
                                                                            <option value="MU">Mauritius</option>
                                                                            <option value="YT">Mayotte</option>
                                                                            <option value="MX">Mexico</option>
                                                                            <option value="MD">Moldova</option>
                                                                            <option value="MC">Monaco</option>
                                                                            <option value="MN">Mongolia</option>
                                                                            <option value="ME">Montenegro</option>
                                                                            <option value="MS">Montserrat</option>
                                                                            <option value="MA">Morocco</option>
                                                                            <option value="MZ">Mozambique</option>
                                                                            <option value="MM">Myanmar (Burma)</option>
                                                                            <option value="NA">Namibia</option>
                                                                            <option value="NR">Nauru</option>
                                                                            <option value="NP">Nepal</option>
                                                                            <option value="NL">Netherlands</option>
                                                                            <option value="NC">New Caledonia</option>
                                                                            <option value="NZ">New Zealand</option>
                                                                            <option value="NI">Nicaragua</option>
                                                                            <option value="NE">Niger</option>
                                                                            <option value="NG">Nigeria</option>
                                                                            <option value="NU">Niue</option>
                                                                            <option value="MK">North Macedonia</option>
                                                                            <option value="NO">Norway</option>
                                                                            <option value="OM">Oman</option>
                                                                            <option value="PK">Pakistan</option>
                                                                            <option value="PS">Palestinian Territories
                                                                            </option>
                                                                            <option value="PA">Panama</option>
                                                                            <option value="PG">Papua New Guinea</option>
                                                                            <option value="PY">Paraguay</option>
                                                                            <option value="PE">Peru</option>
                                                                            <option value="PH">Philippines</option>
                                                                            <option value="PN">Pitcairn Islands</option>
                                                                            <option value="PL">Poland</option>
                                                                            <option value="PT">Portugal</option>
                                                                            <option value="PR">Puerto Rico</option>
                                                                            <option value="QA">Qatar</option>
                                                                            <option value="RE">Réunion</option>
                                                                            <option value="RO">Romania</option>
                                                                            <option value="RU">Russia</option>
                                                                            <option value="RW">Rwanda</option>
                                                                            <option value="WS">Samoa</option>
                                                                            <option value="SM">San Marino</option>
                                                                            <option value="ST">São Tomé &amp; Príncipe
                                                                            </option>
                                                                            <option value="SA">Saudi Arabia</option>
                                                                            <option value="SN">Senegal</option>
                                                                            <option value="RS">Serbia</option>
                                                                            <option value="SC">Seychelles</option>
                                                                            <option value="SL">Sierra Leone</option>
                                                                            <option value="SG">Singapore</option>
                                                                            <option value="SX">Sint Maarten</option>
                                                                            <option value="SK">Slovakia</option>
                                                                            <option value="SI">Slovenia</option>
                                                                            <option value="SB">Solomon Islands</option>
                                                                            <option value="SO">Somalia</option>
                                                                            <option value="ZA">South Africa</option>
                                                                            <option value="GS">South Georgia &amp; South
                                                                                Sandwich Islands</option>
                                                                            <option value="KR">South Korea</option>
                                                                            <option value="SS">South Sudan</option>
                                                                            <option value="ES">Spain</option>
                                                                            <option value="LK">Sri Lanka</option>
                                                                            <option value="BL">St Barthélemy</option>
                                                                            <option value="SH">St Helena</option>
                                                                            <option value="KN">St Kitts &amp; Nevis
                                                                            </option>
                                                                            <option value="LC">St Lucia</option>
                                                                            <option value="MF">St Martin</option>
                                                                            <option value="PM">St Pierre &amp; Miquelon
                                                                            </option>
                                                                            <option value="VC">St Vincent &amp;
                                                                                Grenadines</option>
                                                                            <option value="SR">Suriname</option>
                                                                            <option value="SJ">Svalbard &amp; Jan Mayen
                                                                            </option>
                                                                            <option value="SE">Sweden</option>
                                                                            <option value="CH">Switzerland</option>
                                                                            <option value="TW">Taiwan</option>
                                                                            <option value="TJ">Tajikistan</option>
                                                                            <option value="TZ">Tanzania</option>
                                                                            <option value="TH">Thailand</option>
                                                                            <option value="TL">Timor-Leste</option>
                                                                            <option value="TG">Togo</option>
                                                                            <option value="TK">Tokelau</option>
                                                                            <option value="TO">Tonga</option>
                                                                            <option value="TT">Trinidad &amp; Tobago
                                                                            </option>
                                                                            <option value="TA">Tristan da Cunha</option>
                                                                            <option value="TN">Tunisia</option>
                                                                            <option value="TR">Turkey</option>
                                                                            <option value="TM">Turkmenistan</option>
                                                                            <option value="TC">Turks &amp; Caicos
                                                                                Islands</option>
                                                                            <option value="TV">Tuvalu</option>
                                                                            <option value="UG">Uganda</option>
                                                                            <option value="UA">Ukraine</option>
                                                                            <option value="AE">United Arab Emirates
                                                                            </option>
                                                                            <option value="GB">United Kingdom</option>
                                                                            <option value="US">United States</option>
                                                                            <option value="UY">Uruguay</option>
                                                                            <option value="UZ">Uzbekistan</option>
                                                                            <option value="VU">Vanuatu</option>
                                                                            <option value="VA">Vatican City</option>
                                                                            <option value="VE">Venezuela</option>
                                                                            <option value="VN">Vietnam</option>
                                                                            <option value="WF">Wallis &amp; Futuna
                                                                            </option>
                                                                            <option value="EH">Western Sahara</option>
                                                                            <option value="YE">Yemen</option>
                                                                            <option value="ZM">Zambia</option>
                                                                            <option value="ZW">Zimbabwe</option>
                                                                        </select><svg
                                                                            class="InlineSVG Icon Select-arrow Icon--sm"
                                                                            focusable="false" viewBox="0 0 12 12">
                                                                            <path
                                                                                d="M10.193 3.97a.75.75 0 0 1 1.062 1.062L6.53 9.756a.75.75 0 0 1-1.06 0L.745 5.032A.75.75 0 0 1 1.807 3.97L6 8.163l4.193-4.193z"
                                                                                fill-rule="evenodd"></path>
                                                                        </svg></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="FormFieldGroup-child FormFieldGroup-child--width-12 FormFieldGroup-childLeft FormFieldGroup-childRight">
                                                            <div class="FormFieldInput"><span class="InputContainer"
                                                                    data-max=""><input
                                                                        class="CheckoutInput Input Input--empty"
                                                                        autocomplete="billing address-line1"
                                                                        autocorrect="off" spellcheck="false"
                                                                        id="billingAddressLine1"
                                                                        name="billingAddressLine1" disabled=""
                                                                        type="text" aria-label="Address line 1"
                                                                        placeholder="Address"
                                                                        aria-invalid="false" aria-describedby=""
                                                                        value=""></span></div>
                                                        </div>
                                                        <div
                                                            class="FormFieldGroup-child FormFieldGroup-child--width-12 FormFieldGroup-childLeft FormFieldGroup-childRight">
                                                            <div class="FormFieldInput"><span class="InputContainer"
                                                                    data-max=""><input
                                                                        class="CheckoutInput Input Input--empty"
                                                                        autocomplete="billing address-line2"
                                                                        autocorrect="off" spellcheck="false"
                                                                        id="billingAddressLine2"
                                                                        name="state" disabled=""
                                                                        type="text" aria-label="Address"
                                                                        placeholder="Address" 
                                                                        aria-invalid="false" aria-describedby=""
                                                                        value=""></span></div>
                                                        </div>
                                                        <div
                                                            class="FormFieldGroup-child FormFieldGroup-child--width-6 FormFieldGroup-childLeft FormFieldGroup-childBottom">
                                                            <div class="FormFieldInput"><span class="InputContainer"
                                                                    data-max=""><input
                                                                        class="CheckoutInput Input Input--empty"
                                                                        autocomplete="billing address-level2"
                                                                        autocorrect="off" spellcheck="false"
                                                                        id="billingLocality" name="city"
                                                                        disabled="" type="text" aria-label="City"
                                                                        placeholder="City" aria-invalid="false"
                                                                        aria-describedby="" value=""></span></div>
                                                        </div>
                                                        <div
                                                            class="FormFieldGroup-child FormFieldGroup-child--width-6 FormFieldGroup-childRight FormFieldGroup-childBottom">
                                                            <div class="FormFieldInput"><span class="InputContainer"
                                                                    data-max=""><input
                                                                        class="CheckoutInput Input Input--empty"
                                                                        autocomplete="billing postal-code"
                                                                        autocorrect="off" spellcheck="false"
                                                                        id="billingPostalCode" name="billingPostalCode"
                                                                        type="text" disabled="" aria-label="Postal code"
                                                                        placeholder="Postal code" aria-invalid="false"
                                                                        aria-describedby="" value=""></span></div>
                                                        </div>
                                                        <div style="opacity: 0; height: 0px;"><span
                                                                class="FieldError Text Text-color--red Text-fontSize--13"><span
                                                                    aria-hidden="true"></span></span></div>
                                                    </div>
                                                    <div style="opacity: 0; height: 0px;"><span
                                                            class="FieldError Text Text-color--red Text-fontSize--13"><span
                                                                aria-hidden="true"></span></span></div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-item width-12"></div>
                            <div class="flex-item width-12"><button class="SubmitButton SubmitButton--incomplete"
                                    type="submit"
                                    style="background-color: rgb(36, 103, 182); color: rgb(255, 255, 255);">
                                    <div class="SubmitButton-Shimmer"
                                        style="background: linear-gradient(to right, rgba(36, 103, 182, 0) 0%, rgb(68, 125, 207) 50%, rgba(36, 103, 182, 0) 100%);">
                                    </div>
                                    <div class="SubmitButton-TextContainer"><span
                                            class="SubmitButton-Text SubmitButton-Text--current Text Text-color--default Text-fontWeight--500 Text--truncate"
                                            aria-hidden="false">Pay US${{$Transactions->transaction_amount}}</span><span
                                            class="SubmitButton-Text SubmitButton-Text--pre Text Text-color--default Text-fontWeight--500 Text--truncate"
                                            aria-hidden="true">Processing...</span></div>
                                    <div class="SubmitButton-IconContainer">
                                        <div class="SubmitButton-Icon SubmitButton-Icon--pre">
                                            <div class="Icon Icon--md Icon--square"><svg viewBox="0 0 16 16"
                                                    xmlns="http://www.w3.org/2000/svg" focusable="false">
                                                    <path
                                                        d="M3 7V5a5 5 0 1 1 10 0v2h.5a1 1 0 0 1 1 1v6a2 2 0 0 1-2 2h-9a2 2 0 0 1-2-2V8a1 1 0 0 1 1-1zm5 2.5a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1zM11 7V5a3 3 0 1 0-6 0v2z"
                                                        fill="#ffffff" fill-rule="evenodd"></path>
                                                </svg></div>
                                        </div>
                                        <div class="SubmitButton-Icon SubmitButton-SpinnerIcon SubmitButton-Icon--pre">
                                            <div class="Icon Icon--md Icon--square"><svg viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg" focusable="false">
                                                    <ellipse cx="12" cy="12" rx="10" ry="10"
                                                        style="stroke: rgb(255, 255, 255);"></ellipse>
                                                </svg></div>
                                        </div>
                                    </div>
                                    <div class="SubmitButton-CheckmarkIcon">
                                        <div class="Icon Icon--md"><svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                height="14" focusable="false">
                                                <path d="M 0.5 6 L 8 13.5 L 21.5 0" fill="transparent" stroke-width="2"
                                                    stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg></div>
                                    </div>
                                </button>
                                <div class="ConfirmPayment-PostSubmit">
                                    <div>
                                        <div class="ConfirmTerms Text Text-color--gray500 Text-fontSize--13">By
                                            confirming your payment, you allow to charge your card
                                            for this payment and future payments in accordance with their terms.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
<script>
    @if(Session::has('errorMessage'))
        $('#myModal').modal('toggle')
    @endif
</script>
@endsection

@section('styles')
@parent

{{ Html::style(mix('assets/auth/css/login.css')) }}
@endsection
@section('scripts')
@parent
{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js') }}
{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.14/semantic.js')}}
{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.js') }}
{{ Html::script('assets/admin/js/jquery.validate.min.js') }}
{{ Html::script('assets/admin/js/payments/paymentmethod.js') }}
@endsection