{{-- css and header form authentication form --}}
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/elements.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('client/styles/elements_responsive.css')}}">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<style>
      form {
      border: 5px solid #f1f1f1;
      }
      label[for=image] {
        cursor: pointer;
        transition:.3s ease all;
      }
      label[for=image]:hover {
        scale: 1.1;
      }
      input ,select{
      width: 100%;
      padding: 16px 8px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
      }
      .icon {
      font-size: 210px;
      display: flex;
      justify-content: center;
      color: #ffa37b;
      }
      #icon-image{
      display: inline-block;
      width: 250px;
      height: 250px;
      overflow: hidden;
      border-radius: 50%;
      border: 2px solid gray;
      background-size: cover;
      background-position: center;
      }
      /* .icon img {
        display: inline-block;
        width: 250px;
        height: 250px;
        overflow: hidden;
        border-radius: 50%;
        border: 2px solid gray;
      } */
      button {
      width: 152px;
      height: 54px;
      margin-top: 23px;
      border: none;
      outline: none;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      background-color: #ffa37b;
      color: white;
      padding: 14px 0;
      margin: 10px 0;
      border: none;
      cursor: grab;
      width: 48%;
      }
      h1 {
      text-align:center;
      fone-size:18;
      }
      button:hover {
      opacity: 0.8;
      }
      .formcontainer {
      text-align: center;
      margin: 24px 50px 12px;
      }
      .container {
      padding: 16px 0;
      text-align:left;
      }
      span.psw {
      float: right;
      padding-top: 0;
      padding-right: 15px;
      }
      @media screen and (max-width: 300px) {
      span.psw {
      display: block;
      float: none;
      }
    }
</style>