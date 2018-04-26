<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <title>{{ trans('registeremail.pagetitle') }}</title>

  <style type="text/css">
    /* Take care of image borders and formatting, client hacks */
    img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
    a img { border: none; }
    table { border-collapse: collapse !important;}
    #outlook a { padding:0; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass { width: 100%; }
    .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
    table td { border-collapse: collapse; }
    .ExternalClass * { line-height: 115%; }
    .container-for-gmail-android { min-width: 600px; }


    /* General styling */
    * {
      font-family: Helvetica, Arial, sans-serif;
    }

    body {
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none;
      width: 100% !important;
      margin: 0 !important;
      height: 100%;
      color: #black;
    }

    td {
      font-family: Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #777777;
      text-align: center;
      line-height: 21px;
    }

    a {
      color: #676767;
      text-decoration: none !important;
    }

    .pull-left {
      text-align: left;
    }

    .pull-right {
      text-align: right;
    }

    .header-lg,
    .header-md,
    .header-sm {
      font-size: 32px;
      font-weight: 600;
      line-height: normal;
      padding: 35px 0 0;
      color: #4d4d4d;
    }

    .header-md {
      font-size: 24px;
    }

    .header-sm {
      padding: 5px 0;
      font-size: 18px;
      line-height: 1.3;
    }

    .content-padding {
      padding: 20px 0 30px;
    }

    .mobile-header-padding-right {
      width: 290px;
      text-align: right;
      padding-left: 10px;
    }

    .mobile-header-padding-left {
      width: 290px;
      text-align: left;
      padding-left: 10px;
      padding-bottom: 8px;
    }

    .free-text {
      width: 100% !important;
      padding: 10px 60px 0px;
    }

    .block-rounded {
      border-radius: 5px;
      border: 1px solid #e5e5e5;
      vertical-align: top;
    }

    .button {
      padding: 50px 0px 0px 0px;
    }

    .info-block {
      padding: 0 20px;
      width: 260px;
    }

    .block-rounded {
      width: 260px;
    }

    .info-img {
      width: 258px;
      border-radius: 5px 5px 0 0;
    }

    .force-width-gmail {
      min-width:600px;
      height: 0px !important;
      line-height: 1px !important;
      font-size: 1px !important;
    }

    .button-width {
      width: 228px;
    }

    .btn {
      width:25%;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      cursor: pointer;
      padding: 1.2rem 1.5rem 1.2rem 1.5rem;
      border: none;
      -webkit-border-radius: 0.5rem;
      border-radius: 0.5rem;
      font-size: 1rem;
      color: rgba(255,255,255,0.9);
      -o-text-overflow: clip;
      text-overflow: clip;
      background: #F14904;
      -webkit-box-shadow: 0 0 0 0 rgba(0,0,0,0.2) ;
      box-shadow: 0 0 0 0 rgba(0,0,0,0.2) ;
      text-shadow: 0 0 0 rgba(15,73,168,0.66);
      outline-color:#F14904;
      margin-top:2rem;
    }

  </style>

  <style type="text/css" media="screen">
    @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
  </style>

  <style type="text/css" media="screen">
    @media screen {
      /* Thanks Outlook 2013! http://goo.gl/XLxpyl */
      * {
        font-family: 'Oxygen', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
      }
    }
  </style>

  <style type="text/css" media="only screen and (max-width: 480px)">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {

      td {
        font-size: 20px !important;
        color: black;
      }

      table[class*="container-for-gmail-android"] {
        min-width: 290px !important;
        width: 100% !important;
      }

      table[class="w320"] {
        width: 95% !important;
      }

      img[class="force-width-gmail"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
      }

      a[class="button-width"],
      a[class="button-mobile"] {
        width: 248px !important;
      }

      td[class*="mobile-header-padding-left"] {
        width: 160px !important;
        padding-left: 0 !important;
      }

      td[class*="mobile-header-padding-right"] {
        width: 160px !important;
        padding-right: 0 !important;
      }

      td[class="header-lg"] {
        font-size: 24px !important;
        padding-bottom: 5px !important;
      }

      td[class="header-md"] {
        font-size: 18px !important;
        padding-bottom: 5px !important;
      }

      td[class="content-padding"] {
        padding: 5px 0 30px !important;
      }

       td[class="button"] {
        padding: 5px !important;
      }

      td[class*="free-text"] {
        padding: 10px 18px 30px !important;
      }

      td[class="info-block"] {
        display: block !important;
        width: 280px !important;
        padding-bottom: 40px !important;
      }

      td[class="info-img"],
      img[class="info-img"] {
        width: 278px !important;
      }
    }
  </style>
</head>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.10";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<body style="background-color:background-color: #f7f7f7;">
  <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
    <tbody>
    <tr>
      <td colspan="2" height="30"></td>
    </tr>
    <tr>
      <td valign="top" align="center">
        <a href="https://www.tietalent.com" style="display:inline-block;text-align:center" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=fr&amp;q=https://www.tietalent.com&amp;source=gmail">
          <img src="https://tietalent.com/public/img/logott.png" height="auto" width="160px" border="0" alt="TieTalent" class="CToWUd">
        </a>
      </td>
    </tr>
    <td>&nbsp;</td>
  </tbody>

  <tr>
    <td align="center" valign="top" width="100%" class="content-padding">
      <center>
        <table cellspacing="0" cellpadding="0" class="w320">
          <tr style="margin-top:3rem;padding-top:3rem;">
            <td class="free-text" style="text-align:left;padding-top:2rem;background-color:white;">
              <br/>
              <br/>
                {{ trans('candidateProfileReviewed.hi') }} {{ ucfirst($candidates->firstName) }},
              <br/>
              <br/>{{ trans('candidateProfileReviewed.thankYouRegister') }}
              <br/>
              <br/>{{ trans('candidateProfileReviewed.whenConnected') }}
              <br/>
              <br/>{{ trans('candidateProfileReviewed.chance') }}
              <br/>
              <br/>{{ trans('candidateProfileReviewed.domains') }}
              <ol>
                <li>{{ trans('candidateProfileReviewed.finance') }}</li>
                <li>{{ trans('candidateProfileReviewed.sales') }}</li>
                <li>{{ trans('candidateProfileReviewed.HR') }}</li>
                <li>{{ trans('candidateProfileReviewed.IT') }}</li>
              </ol>
              <br/>
              <br/>{{ trans('candidateProfileReviewed.followUs') }}
              <br/>
              <br/>{{ trans('candidateProfileReviewed.goodLuck') }}
              <br/>
              <br/>{{ trans('candidateProfileReviewed.bestRegards') }}
              <br/>
              <br/>{{ trans('candidateProfileReviewed.TieTalentTeam') }}
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="height: 100px;">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td style="padding: 25px 0 25px">
              <strong style="color:#F14904">TieTalent</strong><br />
              Geneva<br />
              Switzerland<br />
              <span style="color:#F14904">Follow us on:</span> <a href="https://www.facebook.com/tietalent/" style="color:#3B5998;font-size:1rem;">Facebook<i class="fab fa-facebook-square"></i></a> and <a href="https://www.linkedin.com/company/tietalent/" style="color:#0077B5;font-size:1rem;">LinkedIn<i class="fab fa-linkedin"></i></a><br/><br />
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
</table>
</body>
</html>
