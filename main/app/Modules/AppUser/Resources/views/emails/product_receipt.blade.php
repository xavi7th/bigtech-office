<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

  <head>
    <!-- NAME: WIDE -->
    <!--[if gte mso 15]>
<xml>
<o:OfficeDocumentSettings>
<o:AllowPNG/>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your {{ $receipt->product->product_model->name }} Receipt</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script src="{{ asset('js/html2pdf.js') }}"></script>

    <style type="text/css">
      p {
        margin: 10px 0;
        padding: 0;
      }

      table {
        border-collapse: collapse;
      }

      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        display: block;
        margin: 0;
        padding: 0;
      }

      img,
      a img {
        border: 0;
        height: auto;
        outline: none;
        text-decoration: none;
      }

      body,
      #bodyTable,
      #bodyCell {
        height: 100%;
        margin: 0;
        padding: 0;
        width: 100%;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-weight: 400;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
      }

      .mcnPreviewText {
        display: none !important;
      }

      #outlook a {
        padding: 0;
      }

      img {
        -ms-interpolation-mode: bicubic;
      }

      table {
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
      }

      .ReadMsgBody {
        width: 100%;
      }

      .ExternalClass {
        width: 100%;
      }

      p,
      a,
      li,
      td,
      blockquote {
        mso-line-height-rule: exactly;
      }

      a[href^=tel],
      a[href^=sms] {
        color: inherit;
        cursor: default;
        text-decoration: none;
      }

      p,
      a,
      li,
      td,
      body,
      table,
      blockquote {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
      }

      .ExternalClass,
      .ExternalClass p,
      .ExternalClass td,
      .ExternalClass div,
      .ExternalClass span,
      .ExternalClass font {
        line-height: 100%;
      }

      a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
      }

      a.mcnButton {
        display: block;
      }

      .mcnImage,
      .mcnRetinaImage {
        vertical-align: bottom;
      }

      .mcnTextContent {
        word-break: break-word;
      }

      .mcnTextContent img {
        height: auto !important;
      }

      .mcnDividerBlock {
        table-layout: fixed !important;
      }

      /*
      tab Page
      #section background style
      #tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
      */
      body,
      #bodyTable,
      #templateFooter {
        background-color: #FAFAFA;
      }

      /*
      tab Page
      #section background style
      #tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
      */
      #bodyCell {
        border-top: 0;
      }

      /*
      tab Page
      #section heading 1
      #tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
      #style heading 1
      */
      h1 {
        color: #777 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 32px;
        font-style: normal;
        font-weight: normal;
        line-height: 125%;
        letter-spacing: -1px;
        text-align: center;
      }

      /*
      tab Page
      #section heading 2
      #tip Set the styling for all second-level headings in your emails.
      #style heading 2
      */
      h2 {
        color: #777 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 26px;
        font-style: normal;
        font-weight: normal;
        line-height: 125%;
        letter-spacing: -.75px;
        text-align: left;
      }

      /*
      tab Page
      #section heading 3
      #tip Set the styling for all third-level headings in your emails.
      #style heading 3
      */
      h3 {
        color: #777 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 18px;
        font-style: normal;
        font-weight: normal;
        line-height: 125%;
        letter-spacing: -.5px;
        text-align: left;
      }

      /*
      tab Page
      #section heading 4
      #tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
      #style heading 4
      */
      h4 {
        color: #777 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 16px;
        font-style: normal;
        font-weight: normal;
        line-height: 125%;
        letter-spacing: normal;
        text-align: left;
      }

      /*
      tab Preheader
      #section preheader style
      #tip Set the background color and borders for your email's preheader area.
      */
      #templatePreheader {
        background-color: #26ABE2;
        border-top: 0;
        border-bottom: 0;
      }

      /*
      tab Preheader
      #section preheader text
      #tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
      */
      .preheaderContainer .mcnTextContent,
      .preheaderContainer .mcnTextContent p {
        color: #FAFAFA;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 10px;
        line-height: 125%;
        text-align: left;
      }

      /*
      tab Preheader
      #section preheader link
      #tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
      */
      .preheaderContainer .mcnTextContent a {
        color: #FAFAFA;
        font-weight: normal;
        text-decoration: underline;
      }

      /*
      tab Header
      #section header style
      #tip Set the background color and borders for your email's header area.
      */
      #templateHeader {
        background-color: #FAFAFA;
        border-top: 0;
        border-bottom: 0;
      }

      /*
      tab Header
      #section header text
      #tip Set the styling for your email's header text. Choose a size and color that is easy to read.
      */
      .headerContainer .mcnTextContent,
      .headerContainer .mcnTextContent p {
        color: #777;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 14px;
        line-height: 150%;
        text-align: left;
      }

      /*
      tab Header
      #section header link
      #tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
      */
      .headerContainer .mcnTextContent a {
        color: #26ABE2;
        font-weight: normal;
        text-decoration: underline;
      }

      /*
      tab Body
      #section body style
      #tip Set the background color and borders for your email's body area.
      */
      #templateBody {
        background-color: #FAFAFA;
        border-top: 0;
        border-bottom: 0;
      }

      /*
      tab Body
      #section body text
      #tip Set the styling for your email's body text. Choose a size and color that is easy to read.
      */
      .bodyContainer .mcnTextContent,
      .bodyContainer .mcnTextContent p {
        color: #777;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 14px;
        line-height: 150%;
        text-align: left;
      }

      /*
      tab Body
      #section body link
      #tip Set the styling for your email's body links. Choose a color that helps them stand out from your text.
      */
      .bodyContainer .mcnTextContent a {
        color: #26ABE2;
        font-weight: normal;
        text-decoration: underline;
      }

      /*
      tab Footer
      #section footer style
      #tip Set the background color and borders for your email's footer area.
      */
      #templateFooter {
        border-top: 0;
        border-bottom: 0;
      }

      /*
      tab Footer
      #section footer text
      #tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
      */
      .footerContainer .mcnTextContent,
      .footerContainer .mcnTextContent p {
        color: #777;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 10px;
        line-height: 125%;
        text-align: left;
      }

      /*
      tab Footer
      #section footer link
      #tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
      */
      .footerContainer .mcnTextContent a {
        color: #777;
        font-weight: normal;
        text-decoration: underline;
      }

      @media only screen and (max-width: 480px) {

        body,
        table,
        td,
        p,
        a,
        li,
        blockquote {
          -webkit-text-size-adjust: none !important;
        }

      }

      @media only screen and (max-width: 480px) {
        body {
          width: 100% !important;
          min-width: 100% !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .templateContainer {
          max-width: 600px !important;
          width: 100% !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .mcnRetinaImage {
          max-width: 100% !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .mcnImage {
          height: auto !important;
          width: 100% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        .mcnCartContainer,
        .mcnCaptionTopContent,
        .mcnRecContentContainer,
        .mcnCaptionBottomContent,
        .mcnTextContentContainer,
        .mcnBoxedTextContentContainer,
        .mcnImageGroupContentContainer,
        .mcnCaptionLeftTextContentContainer,
        .mcnCaptionRightTextContentContainer,
        .mcnCaptionLeftImageContentContainer,
        .mcnCaptionRightImageContentContainer,
        .mcnImageCardLeftTextContentContainer,
        .mcnImageCardRightTextContentContainer,
        .mcnImageCardLeftImageContentContainer,
        .mcnImageCardRightImageContentContainer {
          max-width: 100% !important;
          width: 100% !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .mcnBoxedTextContentContainer {
          min-width: 100% !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .mcnImageGroupContent {
          padding: 9px !important;
        }

      }

      @media only screen and (max-width: 480px) {

        .mcnCaptionLeftContentOuter .mcnTextContent,
        .mcnCaptionRightContentOuter .mcnTextContent {
          padding-top: 9px !important;
        }

      }

      @media only screen and (max-width: 480px) {

        .mcnImageCardTopImageContent,
        .mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,
        .mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent {
          padding-top: 18px !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .mcnImageCardBottomImageContent {
          padding-bottom: 9px !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .mcnImageGroupBlockInner {
          padding-top: 0 !important;
          padding-bottom: 0 !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .mcnImageGroupBlockOuter {
          padding-top: 9px !important;
          padding-bottom: 9px !important;
        }

      }

      @media only screen and (max-width: 480px) {

        .mcnTextContent,
        .mcnBoxedTextContentColumn {
          padding-right: 18px !important;
          padding-left: 18px !important;
        }

      }

      @media only screen and (max-width: 480px) {

        .mcnImageCardLeftImageContent,
        .mcnImageCardRightImageContent {
          padding-right: 18px !important;
          padding-bottom: 0 !important;
          padding-left: 18px !important;
        }

      }

      @media only screen and (max-width: 480px) {
        .mcpreview-image-uploader {
          display: none !important;
          width: 100% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section heading 1
        #tip Make the first-level headings larger in size for better readability on small screens.
        */
        h1 {
          font-size: 24px !important;
          line-height: 125% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section heading 2
        #tip Make the second-level headings larger in size for better readability on small screens.
        */
        h2 {
          font-size: 20px !important;
          line-height: 125% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section heading 3
        #tip Make the third-level headings larger in size for better readability on small screens.
        */
        h3 {
          font-size: 18px !important;
          line-height: 125% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section heading 4
        #tip Make the fourth-level headings larger in size for better readability on small screens.
        */
        h4 {
          font-size: 16px !important;
          line-height: 125% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section Boxed Text
        #tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
        */
        .mcnBoxedTextContentContainer .mcnTextContent,
        .mcnBoxedTextContentContainer .mcnTextContent p {
          font-size: 18px !important;
          line-height: 125% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section Preheader Visibility
        #tip Set the visibility of the email's preheader on small screens. You can hide it to save space.
        */
        #templatePreheader {
          display: block !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section Preheader Text
        #tip Make the preheader text larger in size for better readability on small screens.
        */
        .preheaderContainer .mcnTextContent,
        .preheaderContainer .mcnTextContent p {
          font-size: 14px !important;
          line-height: 115% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section Header Text
        #tip Make the header text larger in size for better readability on small screens.
        */
        .headerContainer .mcnTextContent,
        .headerContainer .mcnTextContent p {
          font-size: 18px !important;
          line-height: 125% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section Body Text
        #tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
        */
        .bodyContainer .mcnTextContent,
        .bodyContainer .mcnTextContent p {
          font-size: 18px !important;
          line-height: 125% !important;
        }

      }

      @media only screen and (max-width: 480px) {

        /*
        tab Mobile Styles
        #section footer text
        #tip Make the body content text larger in size for better readability on small screens.
        */
        .footerContainer .mcnTextContent,
        .footerContainer .mcnTextContent p {
          font-size: 14px !important;
          line-height: 115% !important;
        }

      }

      #invoice *,
      #invoice ::after,
      #invoice ::before {
        box-sizing: border-box;
      }

      b,
      strong {
        font-weight: bolder;
      }

      p {
        margin-top: 0;
        margin-bottom: 1rem;
      }

      dl,
      ol,
      ul {
        margin-top: 0;
        margin-bottom: 1rem;
      }

      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        margin-top: 0;
        margin-bottom: .5rem;
      }

      address {
        margin-bottom: 1rem;
        font-style: normal;
        line-height: inherit;
      }

      [type=button]:not(:disabled),
      [type=reset]:not(:disabled),
      [type=submit]:not(:disabled),
      button:not(:disabled) {
        cursor: pointer;
      }

      .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
      }

      .no-gutters {
        margin-right: 0;
        margin-left: 0;
      }

      .no-gutters>.col,
      .no-gutters>[class*="col-"] {
        padding-right: 0;
        padding-left: 0;
      }

      .col-1,
      .col-2,
      .col-3,
      .col-4,
      .col-5,
      .col-6,
      .col-7,
      .col-8,
      .col-9,
      .col-10,
      .col-11,
      .col-12,
      .col,
      .col-auto,
      .col-sm-1,
      .col-sm-2,
      .col-sm-3,
      .col-sm-4,
      .col-sm-5,
      .col-sm-6,
      .col-sm-7,
      .col-sm-8,
      .col-sm-9,
      .col-sm-10,
      .col-sm-11,
      .col-sm-12,
      .col-sm,
      .col-sm-auto,
      .col-md-1,
      .col-md-2,
      .col-md-3,
      .col-md-4,
      .col-md-5,
      .col-md-6,
      .col-md-7,
      .col-md-8,
      .col-md-9,
      .col-md-10,
      .col-md-11,
      .col-md-12,
      .col-md,
      .col-md-auto,
      .col-lg-1,
      .col-lg-2,
      .col-lg-3,
      .col-lg-4,
      .col-lg-5,
      .col-lg-6,
      .col-lg-7,
      .col-lg-8,
      .col-lg-9,
      .col-lg-10,
      .col-lg-11,
      .col-lg-12,
      .col-lg,
      .col-lg-auto,
      .col-xl-1,
      .col-xl-2,
      .col-xl-3,
      .col-xl-4,
      .col-xl-5,
      .col-xl-6,
      .col-xl-7,
      .col-xl-8,
      .col-xl-9,
      .col-xl-10,
      .col-xl-11,
      .col-xl-12,
      .col-xl,
      .col-xl-auto {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
      }

      .col {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
      }

      .row-cols-1>* {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
      }

      .row-cols-2>* {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
      }

      .row-cols-3>* {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
      }

      .row-cols-4>* {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
      }

      .row-cols-5>* {
        -ms-flex: 0 0 20%;
        flex: 0 0 20%;
        max-width: 20%;
      }

      .row-cols-6>* {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
      }

      .col-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: 100%;
      }

      .col-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
      }

      .col-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
      }

      .col-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
      }

      .col-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
      }

      .col-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
      }

      .col-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
      }

      .col-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
      }

      .col-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
      }

      .col-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%;
      }

      .col-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%;
      }

      .col-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
      }

      .col-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
      }

      .mt-3,
      .my-3 {
        margin-top: 1rem !important;
      }

      .mt-1,
      .my-1 {
        margin-top: .25rem !important;
      }

      .mt-2,
      .my-2 {
        margin-top: .5rem !important;
      }


      .h2 .small,
      .h2 small {
        font-size: 65%;
      }

      .h1,
      .h2,
      .h3,
      .h4,
      .h5,
      .h6,
      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        margin-bottom: .5rem;
        font-weight: 500;
        line-height: 1.2;
      }

      .h4,
      h4 {
        font-size: 1.5rem;
      }

      @media (min-width: 576px) {
        .col-sm {
          -ms-flex-preferred-size: 0;
          flex-basis: 0;
          -ms-flex-positive: 1;
          flex-grow: 1;
          max-width: 100%;
        }

        .row-cols-sm-1>* {
          -ms-flex: 0 0 100%;
          flex: 0 0 100%;
          max-width: 100%;
        }

        .row-cols-sm-2>* {
          -ms-flex: 0 0 50%;
          flex: 0 0 50%;
          max-width: 50%;
        }

        .row-cols-sm-3>* {
          -ms-flex: 0 0 33.333333%;
          flex: 0 0 33.333333%;
          max-width: 33.333333%;
        }

        .row-cols-sm-4>* {
          -ms-flex: 0 0 25%;
          flex: 0 0 25%;
          max-width: 25%;
        }

        .row-cols-sm-5>* {
          -ms-flex: 0 0 20%;
          flex: 0 0 20%;
          max-width: 20%;
        }

        .row-cols-sm-6>* {
          -ms-flex: 0 0 16.666667%;
          flex: 0 0 16.666667%;
          max-width: 16.666667%;
        }

        .col-sm-auto {
          -ms-flex: 0 0 auto;
          flex: 0 0 auto;
          width: auto;
          max-width: 100%;
        }

        .col-sm-1 {
          -ms-flex: 0 0 8.333333%;
          flex: 0 0 8.333333%;
          max-width: 8.333333%;
        }

        .col-sm-2 {
          -ms-flex: 0 0 16.666667%;
          flex: 0 0 16.666667%;
          max-width: 16.666667%;
        }

        .col-sm-3 {
          -ms-flex: 0 0 25%;
          flex: 0 0 25%;
          max-width: 25%;
        }

        .col-sm-4 {
          -ms-flex: 0 0 33.333333%;
          flex: 0 0 33.333333%;
          max-width: 33.333333%;
        }

        .col-sm-5 {
          -ms-flex: 0 0 41.666667%;
          flex: 0 0 41.666667%;
          max-width: 41.666667%;
        }

        .col-sm-6 {
          -ms-flex: 0 0 50%;
          flex: 0 0 50%;
          max-width: 50%;
        }

        .col-sm-7 {
          -ms-flex: 0 0 58.333333%;
          flex: 0 0 58.333333%;
          max-width: 58.333333%;
        }

        .col-sm-8 {
          -ms-flex: 0 0 66.666667%;
          flex: 0 0 66.666667%;
          max-width: 66.666667%;
        }

        .col-sm-9 {
          -ms-flex: 0 0 75%;
          flex: 0 0 75%;
          max-width: 75%;
        }

        .col-sm-10 {
          -ms-flex: 0 0 83.333333%;
          flex: 0 0 83.333333%;
          max-width: 83.333333%;
        }

        .col-sm-11 {
          -ms-flex: 0 0 91.666667%;
          flex: 0 0 91.666667%;
          max-width: 91.666667%;
        }

        .col-sm-12 {
          -ms-flex: 0 0 100%;
          flex: 0 0 100%;
          max-width: 100%;
        }
      }

      @media (min-width: 768px) {
        .col-md {
          -ms-flex-preferred-size: 0;
          flex-basis: 0;
          -ms-flex-positive: 1;
          flex-grow: 1;
          max-width: 100%;
        }

        .row-cols-md-1>* {
          -ms-flex: 0 0 100%;
          flex: 0 0 100%;
          max-width: 100%;
        }

        .row-cols-md-2>* {
          -ms-flex: 0 0 50%;
          flex: 0 0 50%;
          max-width: 50%;
        }

        .row-cols-md-3>* {
          -ms-flex: 0 0 33.333333%;
          flex: 0 0 33.333333%;
          max-width: 33.333333%;
        }

        .row-cols-md-4>* {
          -ms-flex: 0 0 25%;
          flex: 0 0 25%;
          max-width: 25%;
        }

        .row-cols-md-5>* {
          -ms-flex: 0 0 20%;
          flex: 0 0 20%;
          max-width: 20%;
        }

        .row-cols-md-6>* {
          -ms-flex: 0 0 16.666667%;
          flex: 0 0 16.666667%;
          max-width: 16.666667%;
        }

        .col-md-auto {
          -ms-flex: 0 0 auto;
          flex: 0 0 auto;
          width: auto;
          max-width: 100%;
        }

        .col-md-1 {
          -ms-flex: 0 0 8.333333%;
          flex: 0 0 8.333333%;
          max-width: 8.333333%;
        }

        .col-md-2 {
          -ms-flex: 0 0 16.666667%;
          flex: 0 0 16.666667%;
          max-width: 16.666667%;
        }

        .col-md-3 {
          -ms-flex: 0 0 25%;
          flex: 0 0 25%;
          max-width: 25%;
        }

        .col-md-4 {
          -ms-flex: 0 0 33.333333%;
          flex: 0 0 33.333333%;
          max-width: 33.333333%;
        }

        .col-md-5 {
          -ms-flex: 0 0 41.666667%;
          flex: 0 0 41.666667%;
          max-width: 41.666667%;
        }

        .col-md-6 {
          -ms-flex: 0 0 50%;
          flex: 0 0 50%;
          max-width: 50%;
        }

        .col-md-7 {
          -ms-flex: 0 0 58.333333%;
          flex: 0 0 58.333333%;
          max-width: 58.333333%;
        }

        .col-md-8 {
          -ms-flex: 0 0 66.666667%;
          flex: 0 0 66.666667%;
          max-width: 66.666667%;
        }

        .col-md-9 {
          -ms-flex: 0 0 75%;
          flex: 0 0 75%;
          max-width: 75%;
        }

        .col-md-10 {
          -ms-flex: 0 0 83.333333%;
          flex: 0 0 83.333333%;
          max-width: 83.333333%;
        }

        .col-md-11 {
          -ms-flex: 0 0 91.666667%;
          flex: 0 0 91.666667%;
          max-width: 91.666667%;
        }

        .col-md-12 {
          -ms-flex: 0 0 100%;
          flex: 0 0 100%;
          max-width: 100%;
        }

        .offset-md-1 {
          margin-left: 8.333333%;
        }

        .mt-md-5,
        .my-md-5 {
          margin-top: 3rem !important;
        }

        .mt-md-3,
        .my-md-3 {
          margin-top: 1rem !important;
        }

        .offset-md-7 {
          margin-left: 58.333333%;
        }
      }

      @media (min-width: 992px) {
        .col-lg {
          -ms-flex-preferred-size: 0;
          flex-basis: 0;
          -ms-flex-positive: 1;
          flex-grow: 1;
          max-width: 100%;
        }

        .row-cols-lg-1>* {
          -ms-flex: 0 0 100%;
          flex: 0 0 100%;
          max-width: 100%;
        }

        .row-cols-lg-2>* {
          -ms-flex: 0 0 50%;
          flex: 0 0 50%;
          max-width: 50%;
        }

        .row-cols-lg-3>* {
          -ms-flex: 0 0 33.333333%;
          flex: 0 0 33.333333%;
          max-width: 33.333333%;
        }

        .row-cols-lg-4>* {
          -ms-flex: 0 0 25%;
          flex: 0 0 25%;
          max-width: 25%;
        }

        .row-cols-lg-5>* {
          -ms-flex: 0 0 20%;
          flex: 0 0 20%;
          max-width: 20%;
        }

        .row-cols-lg-6>* {
          -ms-flex: 0 0 16.666667%;
          flex: 0 0 16.666667%;
          max-width: 16.666667%;
        }

        .col-lg-auto {
          -ms-flex: 0 0 auto;
          flex: 0 0 auto;
          width: auto;
          max-width: 100%;
        }

        .col-lg-1 {
          -ms-flex: 0 0 8.333333%;
          flex: 0 0 8.333333%;
          max-width: 8.333333%;
        }

        .col-lg-2 {
          -ms-flex: 0 0 16.666667%;
          flex: 0 0 16.666667%;
          max-width: 16.666667%;
        }

        .col-lg-3 {
          -ms-flex: 0 0 25%;
          flex: 0 0 25%;
          max-width: 25%;
        }

        .col-lg-4 {
          -ms-flex: 0 0 33.333333%;
          flex: 0 0 33.333333%;
          max-width: 33.333333%;
        }

        .col-lg-5 {
          -ms-flex: 0 0 41.666667%;
          flex: 0 0 41.666667%;
          max-width: 41.666667%;
        }

        .col-lg-6 {
          -ms-flex: 0 0 50%;
          flex: 0 0 50%;
          max-width: 50%;
        }

        .col-lg-7 {
          -ms-flex: 0 0 58.333333%;
          flex: 0 0 58.333333%;
          max-width: 58.333333%;
        }

        .col-lg-8 {
          -ms-flex: 0 0 66.666667%;
          flex: 0 0 66.666667%;
          max-width: 66.666667%;
        }

        .col-lg-9 {
          -ms-flex: 0 0 75%;
          flex: 0 0 75%;
          max-width: 75%;
        }

        .col-lg-10 {
          -ms-flex: 0 0 83.333333%;
          flex: 0 0 83.333333%;
          max-width: 83.333333%;
        }

        .col-lg-11 {
          -ms-flex: 0 0 91.666667%;
          flex: 0 0 91.666667%;
          max-width: 91.666667%;
        }

        .col-lg-12 {
          -ms-flex: 0 0 100%;
          flex: 0 0 100%;
          max-width: 100%;
        }
      }

      @media (min-width: 1200px) {
        .col-xl {
          -ms-flex-preferred-size: 0;
          flex-basis: 0;
          -ms-flex-positive: 1;
          flex-grow: 1;
          max-width: 100%;
        }

        .row-cols-xl-1>* {
          -ms-flex: 0 0 100%;
          flex: 0 0 100%;
          max-width: 100%;
        }

        .row-cols-xl-2>* {
          -ms-flex: 0 0 50%;
          flex: 0 0 50%;
          max-width: 50%;
        }

        .row-cols-xl-3>* {
          -ms-flex: 0 0 33.333333%;
          flex: 0 0 33.333333%;
          max-width: 33.333333%;
        }

        .row-cols-xl-4>* {
          -ms-flex: 0 0 25%;
          flex: 0 0 25%;
          max-width: 25%;
        }

        .row-cols-xl-5>* {
          -ms-flex: 0 0 20%;
          flex: 0 0 20%;
          max-width: 20%;
        }

        .row-cols-xl-6>* {
          -ms-flex: 0 0 16.666667%;
          flex: 0 0 16.666667%;
          max-width: 16.666667%;
        }

        .col-xl-auto {
          -ms-flex: 0 0 auto;
          flex: 0 0 auto;
          width: auto;
          max-width: 100%;
        }

        .col-xl-1 {
          -ms-flex: 0 0 8.333333%;
          flex: 0 0 8.333333%;
          max-width: 8.333333%;
        }

        .col-xl-2 {
          -ms-flex: 0 0 16.666667%;
          flex: 0 0 16.666667%;
          max-width: 16.666667%;
        }

        .col-xl-3 {
          -ms-flex: 0 0 25%;
          flex: 0 0 25%;
          max-width: 25%;
        }

        .col-xl-4 {
          -ms-flex: 0 0 33.333333%;
          flex: 0 0 33.333333%;
          max-width: 33.333333%;
        }

        .col-xl-5 {
          -ms-flex: 0 0 41.666667%;
          flex: 0 0 41.666667%;
          max-width: 41.666667%;
        }

        .col-xl-6 {
          -ms-flex: 0 0 50%;
          flex: 0 0 50%;
          max-width: 50%;
        }

        .col-xl-7 {
          -ms-flex: 0 0 58.333333%;
          flex: 0 0 58.333333%;
          max-width: 58.333333%;
        }

        .col-xl-8 {
          -ms-flex: 0 0 66.666667%;
          flex: 0 0 66.666667%;
          max-width: 66.666667%;
        }

        .col-xl-9 {
          -ms-flex: 0 0 75%;
          flex: 0 0 75%;
          max-width: 75%;
        }

        .col-xl-10 {
          -ms-flex: 0 0 83.333333%;
          flex: 0 0 83.333333%;
          max-width: 83.333333%;
        }

        .col-xl-11 {
          -ms-flex: 0 0 91.666667%;
          flex: 0 0 91.666667%;
          max-width: 91.666667%;
        }

        .col-xl-12 {
          -ms-flex: 0 0 100%;
          flex: 0 0 100%;
          max-width: 100%;
        }
      }

      .w-100 {
        width: 100% !important;
      }

      .mt-1,
      .my-1 {
        margin-top: .25rem !important;
      }

      .p-1 {
        padding: .25rem !important;
      }

      .p-0 {
        padding: 0 !important;
      }

      .m-0 {
        margin: 0 !important;
      }

      .lead {
        font-size: 1.25rem;
        font-weight: 300;
      }

      .text-white {
        color: #fff !important;
      }

      .text-center {
        text-align: center !important;
      }

      .bg-danger {
        background-color: #dc3545 !important;
      }

      .invoice {
        position: relative;
        background: #FAFAFA;
        border: 1px solid #EEE;
        box-shadow: 0px 2px 20px 1px #e7e7f2;
        padding: 10px 30px;
        margin: 40px 25px;
      }

      .invoice-title {
        margin-top: 0;
      }

      @media (max-width: 767px) {
        .invoice {
          margin: 0;
        }
      }

      th {
        text-align: inherit;
      }

      .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }

      .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, .05);
      }

      .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
      }

      .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
        color: #555;
      }

      .table td,
      .table th {
        padding: .75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        font-size: 1rem;
      }

      .table>thead>tr>th,
      .table>tbody>tr>th,
      .table>tfoot>tr>th,
      .table>thead>tr>td,
      .table>tbody>tr>td,
      .table>tfoot>tr>td {
        border-top: 1px solid #f4f4f4
      }

      .table>thead>tr>th {
        border-bottom: 2px solid #f4f4f4
      }

      .table-bordered {
        border: 1px solid #f4f4f4
      }

      .table-bordered>thead>tr>th,
      .table-bordered>tbody>tr>th,
      .table-bordered>tfoot>tr>th,
      .table-bordered>thead>tr>td,
      .table-bordered>tbody>tr>td,
      .table-bordered>tfoot>tr>td {
        border: 1px solid #f4f4f4
      }

      .table-bordered>thead>tr>th,
      .table-bordered>thead>tr>td {
        border-bottom-width: 2px
      }

      .table.no-border,
      .table.no-border td,
      .table.no-border th {
        border: 0
      }

      table.text-center,
      table.text-center td,
      table.text-center th {
        text-align: center
      }

      .table.align th {
        text-align: left
      }

      .table.align td {
        text-align: right
      }

      .main-header .logo {
        transition: width .3s ease-in-out;
        display: block;
        float: left;
        height: 50px;
        font-size: 20px;
        line-height: 50px;
        text-align: center;
        width: 230px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";;
        padding: 0 15px;
        font-weight: 300;
        overflow: hidden
      }

      .page-header {
        margin: 10px 0 20px 0;
        font-size: 22px;
        padding-bottom: 9px;
        border-bottom: 1px solid #eee;
      }

      .page-header>small {
        color: #666;
        display: block;
        margin-top: 5px
      }

      .h1 .small,
      .h1 small,
      .h2 .small,
      .h2 small,
      .h3 .small,
      .h3 small,
      h1 .small,
      h1 small,
      h2 .small,
      h2 small,
      h3 .small,
      h3 small {
        font-size: 65%;
      }

      button,
      select {
        text-transform: none;
      }

      .btn {
        display: inline-block;
        font-weight: 400;
        color: #555;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        line-height: 1.5;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        font-family: inherit;
        border-radius: 3px;
        box-shadow: none;
        font-size: 14px;
      }

      .btn.uppercase {
        text-transform: uppercase
      }

      .btn.btn-flat {
        border-radius: 0;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        border-width: 1px
      }

      .btn:active {
        -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        -moz-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125)
      }

      .btn:focus {
        outline: none
      }

      .btn.btn-file {
        position: relative;
        overflow: hidden
      }

      .btn.btn-file>input[type='file'] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        opacity: 0;
        filter: alpha(opacity=0);
        outline: none;
        background: white;
        cursor: inherit;
        display: block
      }

      .btn-default {
        background-color: #f4f4f4;
        color: #444;
        border-color: #ddd
      }

      .btn-default:hover,
      .btn-default:active,
      .btn-default.hover {
        background-color: #e7e7e7
      }

      .btn-primary {
        color: #fff;
        background-color: #3c8dbc;
        border-color: #367fa9
      }

      .btn-primary:hover,
      .btn-primary:active,
      .btn-primary.hover {
        background-color: #367fa9
      }

      .btn-success {
        background-color: #00a65a;
        border-color: #008d4c
      }

      .btn-success:hover,
      .btn-success:active,
      .btn-success.hover {
        background-color: #008d4c
      }

      .btn-info {
        background-color: #00c0ef;
        border-color: #00acd6
      }

      .btn-info:hover,
      .btn-info:active,
      .btn-info.hover {
        background-color: #00acd6
      }

      .btn-danger {
        background-color: #dd4b39;
        border-color: #d73925
      }

      .btn-danger:hover,
      .btn-danger:active,
      .btn-danger.hover {
        background-color: #d73925
      }

      .btn-warning {
        background-color: #f39c12;
        border-color: #e08e0b
      }

      .btn-warning:hover,
      .btn-warning:active,
      .btn-warning.hover {
        background-color: #e08e0b
      }

      .btn-outline {
        border: 1px solid #fff;
        background: transparent;
        color: #fff
      }

      .btn-outline:hover,
      .btn-outline:focus,
      .btn-outline:active {
        color: rgba(255, 255, 255, 0.7);
        border-color: rgba(255, 255, 255, 0.7)
      }

      .btn-link {
        -webkit-box-shadow: none;
        box-shadow: none
      }

      .btn[class*='bg-']:hover {
        -webkit-box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.2)
      }

      .btn-app {
        border-radius: 3px;
        position: relative;
        padding: 15px 5px;
        margin: 0 0 10px 10px;
        min-width: 80px;
        height: 60px;
        text-align: center;
        color: #666;
        border: 1px solid #ddd;
        background-color: #f4f4f4;
        font-size: 12px
      }

      .btn-app>.fa,
      .btn-app>.glyphicon,
      .btn-app>.ion {
        font-size: 20px;
        display: block
      }

      .btn-app:hover {
        background: #f4f4f4;
        color: #444;
        border-color: #aaa
      }

      .btn-app:active,
      .btn-app:focus {
        -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        -moz-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125)
      }

      .btn-app>.badge {
        position: absolute;
        top: -3px;
        right: -10px;
        font-size: 10px;
        font-weight: 400
      }


      .margin {
        margin: 10px;
      }

      .pad {
        padding: 10px;
      }

      .callout {
        border-radius: 3px;
        margin: 0 0 20px 0;
        padding: 15px 30px 15px 15px;
        border-left: 5px solid #eee;
      }

      .callout.callout-info {
        border-color: #0097bc;
        color: #fff !important;
        background-color: #00c0ef !important;
      }

      .callout h4 {
        margin-top: 0;
        font-weight: 600;
      }



      @media print {
        .no-print {
          display: none !important;
        }

        .invoice {
          width: 100%;
          border: 0;
          margin: 0;
          padding: 0;
        }

        .invoice-col {
          float: left;
          width: 33.3333333%;
        }

        .table-responsive {
          overflow: auto;
        }

        .table-responsive>.table tr th,
        .table-responsive>.table tr td {
          white-space: normal !important;
        }
      }

      .box {
        position: relative;
        border-radius: 3px;
        background: #fafafa;
        border-top: 3px solid #d2d6de;
        margin-bottom: 20px;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1)
      }

      .box.box-primary {
        border-top-color: #3c8dbc
      }

      .box.box-info {
        border-top-color: #00c0ef
      }

      .box.box-danger {
        border-top-color: #dd4b39
      }

      .box.box-warning {
        border-top-color: #f39c12
      }

      .box.box-success {
        border-top-color: #00a65a
      }

      .box.box-default {
        border-top-color: #d2d6de
      }

      .box.collapsed-box .box-body,
      .box.collapsed-box .box-footer {
        display: none
      }

      .box-header {
        color: #444;
        display: block;
        padding: 10px;
        position: relative
      }

      .box-header.with-border {
        border-bottom: 1px solid #f4f4f4
      }

      .box-header:before,
      .box-body:before,
      .box-footer:before,
      .box-header:after,
      .box-body:after,
      .box-footer:after {
        content: " ";
        display: table;
      }

      .box-header>.fa,
      .box-header>.glyphicon,
      .box-header>.ion,
      .box-header .box-title {
        display: inline-block;
        font-size: 18px;
        margin: 0;
        line-height: 1;
      }

      .box-body>.table {
        margin-bottom: 0;
      }

      .float-right {
        float: right !important;
      }

      .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
      }

      .company-logo {
        max-width: 120px;
        max-height: 100px;
        ;
      }
    </style>

    <script>
      var saveDiv = function(divId, title) {
        html2pdf(document.getElementById(divId), {
          filename: title + '.pdf',
          image: {
            type: 'jpeg',
            quality: 0.98
          },
          // html2canvas: {
          //   scale: 2
          // },
          jsPDF: {
          // unit: 'in',
          format: 'a3',
          // orientation: 'portrait'
          }
        });
      }

    </script>

  </head>

  <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" onload="saveDiv(divId = 'invoice', filename = 'My {{ $receipt->product->product_model->name }} Receipt - {{ $receipt->created_at->toDateString() }} ')">

      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
          <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
            <!-- BEGIN TEMPLATE // -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%">

              <tr>
                <td align="center" valign="top">
                  <!-- BEGIN BODY // -->
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                    <tr>
                      <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="960" class="templateContainer">
                          <tr>
                            <td valign="top" class="bodyContainer" style="padding-top:0; padding-bottom:9px;">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                  <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                      <!--[if mso]><table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;"><tr><![endif]-->
                                      <!--[if mso]><td valign="top" width="960" style="width:960px;"><![endif]-->
                                      <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                        <tbody>
                                          <tr>
                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                              <section class="invoice" id="invoice">
                                                <div class="row">
                                                  <div class="col-12">
                                                    <h2 class="page-header">
                                                      <!-- <a href="https://www.instagram.com/the_elects/"> -->
                                                      <img class="company-logo" src="{{ asset('img/theelects-receipt-logo-full.png') }}" alt="The Elects">
                                                      <!-- </a> -->
                                                      <small class="float-right" style="line-height: 3">Date: {{ $receipt->created_at->toDateString() }}</small>
                                                    </h2>
                                                  </div>
                                                </div>

                                                <div class="row invoice-info">
                                                  <div class="col-md-6 invoice-col">Supplier
                                                    <address>
                                                      <strong>The Elects</strong>
                                                      <br>
                                                      {!! config('app.address') !!}
                                                      <br>
                                                      Phone: {{ config('app.phone') }}
                                                      <br>
                                                      Email: {{ config('app.email') }}
                                                    </address>
                                                  </div>

                                                  <div class="col-md-6 invoice-col">Customer Details
                                                    <address>
                                                      <strong>{{ $receipt->product->app_user->full_name }}</strong>
                                                      <br>
                                                      {{ $receipt->product->app_user->address }}
                                                      <br>
                                                      {{ $receipt->product->app_user->city }}
                                                      <br>
                                                      Phone:{{ $receipt->product->app_user->phone }}
                                                      <br>
                                                      Email: {{ $receipt->product->app_user->email }}
                                                      <br>
                                                      <br>
                                                      <b>Receipt No: {{ str_pad($receipt->id, 7, '0', STR_PAD_LEFT) }}</b>
                                                      <br> <b>Order Reference Number:</b> {{ $receipt->order_ref }}
                                                    </address>
                                                  </div>
                                                </div>


                                                <div class="row">
                                                  <div class="col-12">
                                                    <div class="box box-primary  mt-3 mt-md-5">
                                                      <div class="box-header with-border">
                                                        <h3 class="box-title">Device Purchased</h3>
                                                      </div>

                                                      <div class="box-body no-padding">
                                                        <div class="table-responsive">
                                                          <table class="table table-striped table-hover">
                                                            <thead>
                                                              <tr>
                                                                <th>Qty</th>
                                                                <th>Product</th>
                                                                <th>Serial #</th>
                                                                <th>Subtotal</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              <tr>
                                                                <td>1</td>
                                                                <td>{{ $receipt->product->product_model->name }}</td>
                                                                <td>{{ $receipt->product->primary_identifier() }}</td>
                                                                <td>{{ to_naira($receipt->amount_paid) }}</td>
                                                              </tr>
                                                            </tbody>
                                                          </table>
                                                        </div>
                                                      </div>
                                                    </div>

                                                  </div>

                                                </div>

                                                @if($receipt->product->swapped_deal_device)


                                                <div class="row">
                                                  <div class="col-12">
                                                    <div class="box box-warning mt-1 mt-md-3">
                                                      <div class="box-header with-border">
                                                        <h3 class="box-title">Swapped With Device</h3>
                                                      </div>

                                                      <div class="box-body no-padding">
                                                        <table class="table table-sm table-hover">
                                                          <thead>
                                                            <tr>
                                                              <th style="width: 10px">#</th>
                                                              <th>Description</th>
                                                              <th>Device Identifier</th>
                                                              <th style="width: 40px">Value</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            <tr>
                                                              <td>1.</td>
                                                              <td>{{ $receipt->product->swapped_deal_device->description }}</td>
                                                              <td>
                                                                {{ $receipt->product->swapped_deal_device->primary_identifier() }}
                                                              </td>
                                                              <td>{{ $receipt->product->swapped_deal_device->swap_value }}</td>
                                                            </tr>
                                                          </tbody>
                                                        </table>
                                                      </div>

                                                    </div>
                                                  </div>
                                                </div>
                                                @endif

                                                <div class="row">
                                                  <div class="col-md-5 offset-md-7 mt-2 mt-md-3">
                                                    <!-- <p class="lead">Amount Due 2/22/2014</p> -->
                                                    <div class="table-responsive">
                                                      <table class="table">
                                                        <tr>
                                                          <th style="width:50%">Subtotal:</th>
                                                          <td>{{ to_naira($receipt->amount_paid) }}</td>
                                                        </tr>
                                                        <tr>
                                                          <th>Tax ({{ $receipt->tax_rate }}%)</th>
                                                          <td>{{ to_naira($receipt->tax_rate / 100 * $receipt->amount_paid) }}</td>
                                                        </tr>
                                                        <tr>
                                                          <th>Shipping:</th>
                                                          <td>{{ to_naira($receipt->delivery_fee ?? 0) }}</td>
                                                        </tr>
                                                        <tr>
                                                          <th>Grand Total:</th>
                                                          <td>
                                                            {{ to_naira($receipt->amount_paid + ($receipt->tax_rate / 100 * $receipt->amount_paid) + $receipt->delivery_fee) }}
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <h4 class="w-100 p-1 text-center bg-danger text-white">TERMS AND CONDITIONS:</h4>
                                                </div>
                                                <div class="row">
                                                  <div class="callout callout-info w-100">
                                                    <div class="row">
                                                      <div class="col-12 p-0">
                                                        <ol>
                                                          <li>New devices procured from The Elects Online store fall under standard manufacturer’s warranty and conditions, and are therefore redeemable at Manufacturer’s warranty/service Centres in Nigeria. All product and after sales issues should be forwarded to Manufacturer’s Warranty Centres for new devices.</li>
                                                          <li>Please ensure that you retain the original packaging of the cell phone as well as the customer pickup document (receipt) as you will be required to produce these for warranty and/or exchange purposes.</li>
                                                          <li>Prior to utilizing your cell phone and/or the battery, it is advisable to first charge the battery for a given time period stipulated by the manufacturer. This will assist the durability of the battery life.</li>
                                                          <li>Warranty provided by the manufacturer does not cover non-manufacturer and/or physical damage and/or liquid damage (dead device) caused by negligent use of the cellphone.</li>
                                                          <li>If caught trading in a stolen device, you agree to be handed over to the appropriate authorities.</li>
                                                          <li>In the event that your cellphone has a manufacturer’s fault and it is identified at the place and time of purchase, the cellphone can be returned for replacement.</li>
                                                          <li>Unless otherwise stipulated by the manufacturer, your cellphone has a warranty cover of one (1) year and battery utilized in conjunction with the cellphone has a warranty cover 6 or 12 (six or twelve) months (depending on the make and model) from date of purchase.</li>
                                                          <li>The Elects offers (14) Fourteen days warranty on used devices. Our warranty does not cover water damage, physical damage caused by negligent use of device and power damages entity from use of non-standard/non-compliant chargers.</li>
                                                          <li>In the event that your used device while under our warranty develops fault covered under our warranty, the cellphone can be returned for repairs. In the event that it cannot be fixed, we will replace the device.</li>
                                                          <li>Should you experience any problems with your cellphone you may either take it directly to The Elects closest technical services centre (Call {{ config('app.complaint_phone_line') }} from your cellphone for a list of outlets) or any other authorized The Elects cellphone repair outlet for Used Devices.</li>
                                                        </ol>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </section>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!--[if mso]></td><![endif]-->

                                      <!--[if mso]></tr></table><![endif]-->
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <!-- // END BODY -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- BEGIN FOOTER // -->
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                    <tr>
                      <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="960" class="templateContainer">
                          <tr>
                            <td valign="top" class="footerContainer" style="padding-top:9px; padding-bottom:9px;">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                                <tbody class="mcnDividerBlockOuter">
                                  <tr>
                                    <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 36px;">
                                      <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;">
                                        <tbody>
                                          <tr>
                                            <td>
                                              <div class="row no-print">
                                                <div class="col-12">
                                                  <button onclick="window.print();" class="btn btn-default">
                                                    <i class="fa fa-print"></i> Print Receipt
                                                  </button>
                                                  <!-- <button type="button" class="btn btn-success float-right"><i class="fa fa-credit-card"></i>Submit Payment</button> -->
                                                  <button type="button" class="btn btn-primary float-right"
                                                          onclick="saveDiv(divId = 'invoice', filename = 'My {{ $receipt->product->product_model->name }} Receipt - {{ $receipt->created_at->toDateString() }} ')">
                                                    <i class="fa fa-download"></i>
                                                    Save as PDF
                                                  </button>
                                                </div>
                                              </div>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!--<td class="mcnDividerBlockInner" style="padding: 18px;"><hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />-->
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%; border-top: 1px solid #DDDDDD;">
                                <tbody class="mcnTextBlockOuter">
                                  <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                      <!--[if mso]><table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;"><tr><![endif]-->

                                      <!--[if mso]><td valign="top" width="960" style="width:960px;"><![endif]-->
                                      <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                        <tbody>
                                          <tr>

                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px; text-align:center;">

                                              <em>Copyright © {{ now()->year }} The Elects, All rights reserved.</em>
                                              <br>
                                              <br>
                                              <strong>Our mailing address is:</strong>
                                              <br>
                                              {{ config('app.email') }}
                                              <br>
                                              <br>
                                              <strong>Our contact phone is:</strong>
                                              <br>
                                              {{ config('app.phone') }}
                                              <br>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!--[if mso]></td><![endif]-->

                                      <!--[if mso]></tr></table><![endif]-->
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <!-- // END FOOTER -->
                </td>
              </tr>
            </table>
            <!-- // END TEMPLATE -->
          </td>
        </tr>
      </table>


  </body>

</html>
