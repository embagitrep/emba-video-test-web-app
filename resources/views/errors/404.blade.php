@extends('client.layout.layout')

@section('content')
    <div class="section section__center section--single js--statusSection">
        <div class="section__separated--item-h">
            <div class="section__header section__header--bordered section__header--center">
                <div class="section__header--img-h ">
                    <img src="/client/images/content/ef.png" class="section__header--img" alt="">
                </div>
            </div>
        </div>


        <div class="js--error">

            <div class="loading__inner">
                <span class="icons icons--error"></span>
            </div>
            <div class="heading heading--3 text--center">{{ getTranslation('Səhifə tapılmadı və ya sessiya başa çatıb') }}</div>

        </div>


    </div>

@endsection