<?php

namespace Flux\Controller;

use Flux\Core\Database\Connector;
use Flux\Core\Helpers\Mailer;
use Flux\Core\Helpers\Session;
use Flux\Core\Http\Request;

class AuthController
{

    /**
     * register. Registers the user.
     *
     * @author    Unknown
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Friday, February 8th, 2019.
     * @version    v1.0.1    Friday, March 1st, 2019.
     * @access    public static
     * @param    string    $table
     * @param    array     $data
     * @return    void
     */
    public static function register(String $table, array $data)
    {
        $connect = Connector::connect();
        $keys = [];
        // $values = [];
        $prepKey = "";
        $prepVal = array();
        $serverName = Request::host();
        //$header = ["FROM" => "no-reply@loginoo.test"];

        $email = $data['email'];
        $name = $data['name'];
        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html' . "\r\n";
        //$header[] = 'MIME-Version: 1.0';
        //$header[] = 'Content-type: text/html; charset=iso-8859-1';

        //var_dump($data);
        if (!is_array($data) && empty($data)) {
            $error = new \PDOException("Values passed must be of type array");
            $error->getMessage();
        }
        /**
         * If the password from the password_confirm input matches the first password entered, then save password value to a variable and unset both password and password_confirm.
         * Pass in new data using the unary array method, this makes the key value pair pushed to not have to be sorted.
         * Hash the password and the activation data.
         */
        if (array_key_exists('password_confirm', $data)) {
            if ($data['password'] === $data['password_confirm']) {
                $pass = $data['password'];
                $activation_code = hash('sha512', $data['name']);
                unset($data['password']);
                unset($data['password_confirm']);
                $data += ['password' => password_hash($pass, PASSWORD_DEFAULT)];
                $data += ['activation_code' => $activation_code];
            }
        }
        /*
         *The foreach loop splits the array given into key and value for each index.
         * The keys are separated into a $keys array, the same is done to the values.
         * A $prepKey array is used for the key binding needed by pdo for the data manipulation.
         * A $prepVal array is used to store the $prepKey and values giving a :name => name Array.
         */
        foreach ($data as $key => $value) {
            $keys[] = $key;
            $values[] = $value;
            $prepKey = ":" . $key; //$prepKey is a variable that stores strings
            $prepVal[$prepKey] = $value;
        }
        /**
         * Use implode not list to separate the array values into a string with a glue string joining them.
         */
        $columns = implode(",", $keys);
        $params = ":" . implode(",:", $keys);

        /**
         * Resulting sql string should contain pdo named placeholder for values and normal string for the columns.
         */
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$params})";

        //Prepare the sql statement for execution by pdo
        $prep = $connect->prepare($sql);

        //Using foreach loop bind the values to their placeholders, represented by the key value pairs in the array.
        foreach ($prepVal as $key => $value) {
            $prep->bindValue($key, $value);
        }
        try {
            $create = $prep->execute();

            $message = "
            <!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
            <head>
            <!--[if gte mso 9]>
            <xml>
              <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
              </o:OfficeDocumentSettings>
            </xml>
            <![endif]-->
              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <meta name='x-apple-disable-message-reformatting'>
              <!--[if !mso]><!--><meta http-equiv='X-UA-Compatible' content='IE=edge'><!--<![endif]-->
              <title></title>
              <style type='text/css'>
                body {
              margin: 0;
              padding: 0;
            }

            table, tr, td {
              vertical-align: top;
              border-collapse: collapse;
            }

            p, ul {
              margin: 0;
            }

            .ie-container table, .mso-container table {
              table-layout: fixed;
            }

            * {
              line-height: inherit;
            }

            a[x-apple-data-detectors=true] {
              color: inherit !important;
              text-decoration: none !important;
            }

            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
              line-height: 100%;
            }

            [owa] .email-row .email-col {
              display: table-cell;
              float: none !important;
              vertical-align: top;
            }

            .ie-container .email-col-100, .ie-container .email-row, [owa] .email-col-100, [owa] .email-row { width: 500px !important; }
            .ie-container .email-col-17, [owa] .email-col-17 { width: 85px !important; }
            .ie-container .email-col-25, [owa] .email-col-25 { width: 125px !important; }
            .ie-container .email-col-33, [owa] .email-col-33 { width: 165px !important; }
            .ie-container .email-col-50, [owa] .email-col-50 { width: 250px !important; }
            .ie-container .email-col-67, [owa] .email-col-67 { width: 335px !important; }

            @media only screen and (min-width: 520px) {
              .email-row { width: 500px !important; }
              .email-row .email-col { vertical-align: top; }
              .email-row .email-col-100 { width: 500px !important; }
              .email-row .email-col-67 { width: 335px !important; }
              .email-row .email-col-50 { width: 250px !important; }
              .email-row .email-col-33 { width: 165px !important; }
              .email-row .email-col-25 { width: 125px !important; }
              .email-row .email-col-17 { width: 85px !important; }
            }

            @media (max-width: 520px) {
              .hide-mobile { display: none !important; }
              .email-row-container {
                padding-left: 0px !important;
                padding-right: 0px !important;
              }
              .email-row .email-col {
                min-width: 320px !important;
                max-width: 100% !important;
                display: block !important;
              }
              .email-row { width: calc(100% - 40px) !important; }
              .email-col { width: 100% !important; }
              .email-col > div { margin: 0 auto; }
              .no-stack .email-col { min-width: 0 !important; display: table-cell !important; }
              .no-stack .email-col-50 { width: 50% !important; }
              .no-stack .email-col-33 { width: 33% !important; }
              .no-stack .email-col-67 { width: 67% !important; }
              .no-stack .email-col-25 { width: 25% !important; }
              .no-stack .email-col-17 { width: 17% !important; }
            }

              </style>

            <!--[if mso]>
            <style type='text/css'>
              ul li {
                list-style:disc inside;
                mso-special-format:bullet;
              }
            </style>
            <![endif]-->

            </head>

            <body class='clean-body' style='margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e4e4e4'>
              <!--[if IE]><div class='ie-container'><![endif]-->
              <!--[if mso]><div class='mso-container'><![endif]-->
              <table class='nl-container' style='border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e4e4e4;width:100%' cellpadding='0' cellspacing='0'>
              <tbody>
              <tr style='vertical-align: top'>
                <td style='word-break: break-word;border-collapse: collapse !important;vertical-align: top'>
                <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td align='center' style='background-color: #e4e4e4;'><![endif]-->

            <div class='email-row-container' style='padding: 10px;background-color: rgba(255,255,255,0)'>
              <div style='Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;' class='email-row'>
                <div style='border-collapse: collapse;display: table;width: 100%;background-color: transparent;'>
                  <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 10px;background-color: rgba(255,255,255,0);' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:500px;'><tr style='background-color: transparent;'><![endif]-->

            <!--[if (mso)|(IE)]><td align='center' width='500' style='width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]-->
            <div class='email-col email-col-100' style='max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;'>
              <div style='width: 100% !important;'>
              <!--[if (!mso)&(!IE)]><!--><div style='padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

            <table id='u_content_text_1' class='u_content_text' style='font-family:arial,helvetica,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
              <tbody>
                <tr>
                  <td style='overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;' align='left'>

              <div style='color: #000; line-height: 140%; text-align: left; word-wrap: break-word;'>
                <p style='line-height: 140%; font-size: 14px;'><span style='font-size: 20px; line-height: 28px;'>Hello, $name</span></p>
              </div>

                  </td>
                </tr>
              </tbody>
            </table>

            <table id='u_content_divider_1' class='u_content_divider' style='font-family:arial,helvetica,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
              <tbody>
                <tr>
                  <td style='overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;' align='left'>

              <table height='0px' align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'>
                <tbody>
                  <tr style='vertical-align: top'>
                    <td style='word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'>
                      <span>&#160;</span>
                    </td>
                  </tr>
                </tbody>
              </table>

                  </td>
                </tr>
              </tbody>
            </table>

              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
            <!--[if (mso)|(IE)]></td><![endif]-->
                  <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>

            <div class='email-row-container' style='padding: 8px;background-color: #e5e5e5'>
              <div style='Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #5e96a4;' class='email-row'>
                <div style='border-collapse: collapse;display: table;width: 100%;background-color: #5e96a4;'>
                  <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 8px;background-color: #e5e5e5;' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:500px;'><tr style='background-color: #5e96a4;'><![endif]-->

            <!--[if (mso)|(IE)]><td align='center' width='500' style='width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]-->
            <div class='email-col email-col-100' style='max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;'>
              <div style='width: 100% !important;'>
              <!--[if (!mso)&(!IE)]><!--><div style='padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

            <table id='u_content_text_2' class='u_content_text' style='font-family:arial,helvetica,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'>
              <tbody>
                <tr>
                  <td style='overflow-wrap:break-word;word-break:break-word;padding:50px 10px;font-family:arial,helvetica,sans-serif;' align='left'>

              <div style='color: #fffefe; line-height: 140%; text-align: center; word-wrap: break-word;'>
                <p style='font-size: 14px; line-height: 140%;'>Click the link below to complete your registration.</p>
                <a style='text-decoration:none;width:300px;' target='_blank' href='http://$serverName/activate/$email/$activation_code'>ACTIVATE</a>
            <p style='font-size: 14px; line-height: 140%;'>&nbsp;</p>
              </div>

                  </td>
                </tr>
              </tbody>
            </table>

              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
            <!--[if (mso)|(IE)]></td><![endif]-->
                  <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>

                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
              </tr>
              </tbody>
              </table>
              <!--[if (mso)|(IE)]></div><![endif]-->
            </body>

            </html>
            ";

            Mailer::send($email, "Click the button below to activate your account", $message, $header);
            return $create;
        } catch (\Throwable $th) {
            Session::create('danger', 'Unsuccessful Registration!!');
        }

    }


    /**
     * @param array $data
     */
    public static function activate(array $data)
    {
        $email = $data['email'];
        $activation_code = $data['activation_code'];
        $connect = Connector::connect();

        try {
            $sql = "SELECT id  FROM users WHERE email=:email AND activation_code=:activation_code";
            var_dump($sql);

            $user = $connect->prepare($sql);
            //var_dump($user);
            $user->execute(["email" => $email, "activation_code" => $activation_code]);
            $count = $user->rowCount();
            //dd($count);
            if ($count > 0) {
                $sql = "UPDATE users SET activation_confirm=1, activation_code=0 WHERE email=:email";
                $user = $connect->prepare($sql);
                //var_dump($user);
                $user->execute(["email" => $email]);
                $count = $user->rowCount();
                //dd($count);
                if ($count > 0) {
                    Session::create('success', 'You can now login to your account');
                    redirect('/');
                }
            } else {
                Session::create('danger', 'Unsuccessful Activation!!');
            }

        } catch (\Throwable $th) {
            //throw $th;
            Session::create('danger', 'Unsuccessful Activation!!');
        }

    }

    /**
     * login.Returns true or false if credentials are not found in the database.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Wednesday, March 6th, 2019.
     * @access    public static
     * @param    string    $table
     * @param    array     $data
     * @return    void
     */
    public static function login(String $table, array $data)
    {
        $connect = Connector::connect();
        $email = $data['email'];
        $password = $data['password'];

        if (!is_string($table)) {
            throw new \PDOException("Datatype must be of type String");
        }
        if (!is_array($data) && empty($data)) {
            throw new \PDOException("Values passed must be of type array");
            //$error->getMessage();
        }
        try {
            $sql = "SELECT `password` FROM $table WHERE email=:email";
            //var_dump($sql);
            $user = $connect->prepare($sql);
            //var_dump($user);
            $user->execute(["email" => $email]);
            $password_confirm = $user->fetchColumn();
            //dd($password_confirm);
            $count = $user->rowCount();
            //var_dump($count);
            if ($count > 0) {
                if (!password_verify($password, $password_confirm)) {
                    Session::create('warning', 'Check Password!!');
                    return redirect('/');

                }
                setcookie('loggedIn','true',time()+3600);
                return $count;
            }
            Session::create('warning', 'Check Email!!');
            return redirect('/');

        } catch (\PDOException $th) {
            $th->getMessage();
        }

    }

    public static function logout()
    {
      if (session_status() == PHP_SESSION_ACTIVE) {
        session_destroy();
        setcookie('loggedIn','true',1);
        //setcookie('email');
        // unset($_SESSION['PHPSESSID']);
        // unset($_COOKIE['email']);
        //return redirect('/');
      }
      return redirect('/');
      }

}
