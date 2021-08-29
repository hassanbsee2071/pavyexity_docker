<?php

use Illuminate\Database\Seeder;
use App\EmailManagement;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailManagement::firstOrCreate(
            ['email_subject' => 'InvitationMail', 'email_slug' =>'InvitationMail', 'email_body' =>'<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#ffffff; vertical-align:top">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#2a3f54">
                    <h2>Payvex</h2>
</td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#ffffff; height:24px">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#ffffff">
                    <p>Below is Payvexity register link ,After Registration for Payvexity you can use these details to login to your account.</p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#ffffff; height:48px">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#ffffff">
                    <p>Register link : {{Registerlink}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#ffffff">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#ffffff; height:48px">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#dbe5ea">
                    <p>&nbsp;</p>
        
                    <p>&copy;2020 Payvexity. All rights reserved.</p>
                    </td>
                </tr>
            </tbody>
        </table>']
        );
        
        EmailManagement::firstOrCreate(
            ['email_subject' => 'Company Account Alert', 'email_slug' =>'Acc Alert', 'email_body' =>'<p>Congratulations You have created a new company</p>']
        );

        EmailManagement::firstOrCreate(
            ['email_subject' => 'company', 'email_slug' =>'company', 'email_body' =>'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            </head>
            <body style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
            <style>
            @media  only screen and (max-width: 600px) {
            .inner-body {
            width: 100% !important;
            }
            
            .footer {
            width: 100% !important;
            }
            }
            
            @media  only screen and (max-width: 500px) {
            .button {
            width: 100% !important;
            }
            }
            </style>
            
            <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; margin: 0; padding: 0; width: 100%;">
            <tr>
            <td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 0; padding: 0; width: 100%;">
            <tr>
            <td class="header" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; padding: 25px 0; text-align: center;">
            <a href="http://localhost" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;">
            Payvexity
            </a>
            </td>
            </tr>
            
            <!-- Email Body -->
            <tr>
            <td class="body" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%;">
            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">
            <!-- Body content -->
            <tr>
            <td class="content-cell" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; max-width: 100vw; padding: 32px;"><p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Hello <?php $name= 0; ($name == null) ? \'Client\' : $name ?>,<br>
            Thank you for choosing Payvexity!</p>
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Your account is registered with <strong style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">Payvexity</strong> with admin role assigned to  <strong style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">Admin</strong></p>
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Your account is associated with:
            <strong style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">Email</strong>: <?php $email = 0; ($email == null) ? \'***\' : $email ?></p>
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Sincerely,<br>
            Payvexity team.</p>
            
            
            
            </td>
            </tr>
            </table>
            </td>
            </tr>
            
            <tr>
            <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
            <tr>
            <td class="content-cell" align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; max-width: 100vw; padding: 32px;">
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">© 2021 Payvexity. All rights reserved.</p>
            
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            </body>
            </html>']
        );

        EmailManagement::firstOrCreate(
            ['email_subject' => 'account-create', 'email_slug' =>'account-create', 'email_body' =>'<p>&nbsp;</p>

            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>
                        <table cellpadding="0" cellspacing="0" style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="text-align:center"><a href="http://localhost">Payvexity </a></td>
                                </tr>
                                <!-- Email Body -->
                                <tr>
                                    <td style="background-color:#edf2f7; border-bottom:1px solid #edf2f7; border-top:1px solid #edf2f7; width:100%">
                                    <table align="center" cellpadding="0" cellspacing="0" style="width:570px"><!-- Body content -->
                                        <tbody>
                                            <tr>
                                                <td>
                                                <p>Hello <strong><!--?php $name= 0; {{($name == null) ? \'Client\' : $name}} ?--></strong>,<br />
                                                Thank you for choosing Payvexity!</p>
            
                                                <p>Your account is registered with <strong>Payvexity</strong> by <!--?php $sender = 0;  {{($sender == null) ? \'***\' : $sender}} ?--></p>
            
                                                <p>Your account details are: <strong>Email</strong>: <!--?php $email = 0;  {{($email == null) ? \'***\' : $email}} ?--> <strong>Password</strong>: <!--?php $password = 0;  {{($password == null) ? \'***\' : $password}} ?--></p>
            
                                                <p>You can click this button to use your login</p>
            
                                                <table align="center" cellpadding="0" cellspacing="0" style="width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><a href="https://staging.vultik.com/payvexitylive/login" target="_blank">Login</a></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
            
                                                <p>Sincerely,<br />
                                                Payvexity team.</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <table align="center" cellpadding="0" cellspacing="0" style="width:570px">
                                        <tbody>
                                            <tr>
                                                <td>
                                                <p>&copy; 2021 Payvexity. All rights reserved.</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>
                        <table cellpadding="0" cellspacing="0" style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="text-align:center"><a href="http://localhost">Payvexity </a></td>
                                </tr>
                                <!-- Email Body -->
                                <tr>
                                    <td style="background-color:#edf2f7; border-bottom:1px solid #edf2f7; border-top:1px solid #edf2f7; width:100%">
                                    <table align="center" cellpadding="0" cellspacing="0" style="width:570px"><!-- Body content -->
                                        <tbody>
                                            <tr>
                                                <td>
                                                <p>Hello <strong><!--?php $name= 0; {{($name == null) ? \'Client\' : $name}} ?--></strong>,<br />
                                                Thank you for choosing Payvexity!</p>
            
                                                <p>Your account is registered with <strong>Payvexity</strong> by <!--?php $sender = 0;  {{($sender == null) ? \'***\' : $sender}} ?--></p>
            
                                                <p>Your account details are: <strong>Email</strong>: <!--?php $email = 0;  {{($email == null) ? \'***\' : $email}} ?--> <strong>Password</strong>: <!--?php $password = 0;  {{($password == null) ? \'***\' : $password}} ?--></p>
            
                                                <p>You can click this button to use your login</p>
            
                                                <table align="center" cellpadding="0" cellspacing="0" style="width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><a href="http://127.0.0.1:8000/login" target="_blank">Login</a></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
            
                                                <p>Sincerely,<br />
                                                Payvexity team.</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <table align="center" cellpadding="0" cellspacing="0" style="width:570px">
                                        <tbody>
                                            <tr>
                                                <td>
                                                <p>&copy; 2021 Payvexity. All rights reserved.</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>']
        );

        EmailManagement::firstOrCreate(
            ['email_subject' => 'payment-receive', 'email_slug' =>'payment-receive', 'email_body' =>'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            </head>
            <body style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
            <style>
            @media  only screen and (max-width: 600px) {
            .inner-body {
            width: 100% !important;
            }
            
            .footer {
            width: 100% !important;
            }
            }
            
            @media  only screen and (max-width: 500px) {
            .button {
            width: 100% !important;
            }
            }
            </style>
            
            <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; margin: 0; padding: 0; width: 100%;">
            <tr>
            <td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 0; padding: 0; width: 100%;">
            <tr>
            <td class="header" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\',\'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; padding: 25px 0; text-align: center;">
            <a href="http://localhost" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;">
            Payvexity
            </a>
            </td>
            </tr>
            
            <!-- Email Body -->
            <tr>
            <td class="body" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%;">
            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">
            <!-- Body content -->
            <tr>
            <td class="content-cell" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; max-width: 100vw; padding: 32px;">
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Hello <strong style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;"><?php $name= 0; ($name == null) ? \'Client\' : $name ?></strong>,<br>
            Thank you for choosing Payvexity!</p>
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
            You have received payment from <?php $email = 0; ($email == null) ? \'***\' : $email ?></p>
            <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
            <tr>
            <td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <tr>
            <td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <tr>
            <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <a href="http://127.0.0.1:8000/login" class="button button-primary" target="_blank" rel="noopener" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\',\'Segoe UI Symbol\'; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;">Proceed with Payment</a>
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Sincerely,<br>
            Payvexity team.</p>
            
            
            
            </td>
            </tr>
            </table>
            </td>
            </tr>
            
            <tr>
            <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
            <tr>
            <td class="content-cell" align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; max-width: 100vw; padding: 32px;">
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">© 2021 Payvexity. All rights reserved.</p>
            
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            </body>
            </html>']
        );

        EmailManagement::firstOrCreate(
            ['email_subject' => 'invoice', 'email_slug' =>'invoice', 'email_body' =>'<table cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td>
                    <table cellpadding="0" cellspacing="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="text-align:center">Payvexity</td>
                            </tr>
                            <!-- Email Body -->
                            <tr>
                                <td style="background-color:#edf2f7; border-bottom:1px solid #edf2f7; border-top:1px solid #edf2f7; width:100%">
                                <table align="center" cellpadding="0" cellspacing="0" style="width:570px"><!-- Body content -->
                                    <tbody>
                                        <tr>
                                            <td>
                                            <p>Hello ,<br />
                                            Thank you for choosing Payvexity!</p>
        
                                            <p>Please find the invoice in attachment</p>
        
                                            <table align="center" cellpadding="0" cellspacing="0" style="width:100%">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><a href="https://staging.vultik.com/payvexitylive/login" target="_blank">Login To Payvexity</a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
        
                                            <p>Sincerely,<br />
                                            Payvexity team.</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <table align="center" cellpadding="0" cellspacing="0" style="width:570px">
                                    <tbody>
                                        <tr>
                                            <td>
                                            <p>&copy; 2021 Payvexity. All rights reserved.</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody>
        </table>']
        );


        EmailManagement::firstOrCreate(
            ['email_subject' => 'welcome Email', 'email_slug' =>'welcome', 'email_body' =>'<p><strong>Vultik welocomesyou on board. Wish you&nbsp;good luck!</strong></p>']
        );

        EmailManagement::firstOrCreate(
            ['email_subject' => 'PayAlert', 'email_slug' =>'PayAlert', 'email_body' =>'<p>PayAlert</p>']
        );
        EmailManagement::firstOrCreate(
            ['email_subject' => 'Invoice Aler', 'email_slug' =>'Invoice Aler', 'email_body' =>'<p>Invoice Alert</p>']
        );
        EmailManagement::firstOrCreate(
            ['email_subject' => 'New User', 'email_slug' =>'New User', 'email_body' =>'<p>New User Added</p>']
        );
    }
}
