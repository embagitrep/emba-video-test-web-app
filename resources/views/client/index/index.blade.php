@extends('client.layout.layout')

@section('content')

    <!-- Camera Permission Modal -->
    <div id="cameraPermissionModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:12px; padding:40px 32px; max-width:420px; width:90%; text-align:center; box-shadow:0 8px 32px rgba(0,0,0,0.2);">
            <div style="font-size:48px; margin-bottom:16px;">📷</div>
            <h3 style="margin:0 0 12px; font-size:20px; font-weight:700;">{{ getTranslation('Kameraya icazə verin') }}</h3>
            <p style="margin:0 0 28px; color:#555; font-size:15px; line-height:1.5;">{{ getTranslation('Video çəkiliş üçün kamera və mikrofona icazə verməniz tələb olunur.') }}</p>
            <button id="allowCameraBtn" style="background:#28a745; color:#fff; border:none; border-radius:8px; padding:14px 36px; font-size:16px; font-weight:600; cursor:pointer; width:100%;">
                {{ getTranslation('İcazə ver') }}
            </button>
        </div>
    </div>

    <script>
   var fileUploadPath = "{{ request()->getSchemeAndHttpHost() }}:7443/upload-video/{{ $sessionId }}"
   </script>

    <?php
    $isEF = false;
    if ($model->merchant->slug == 'embafinans') {
        $isEF = true;
    }
    ?>

    <div class="section section__center section--single js--statusSection" style="display:none;">
        <div class="section__separated--item-h">
            <div class="section__header section__header--bordered section__header--center">
                <div class="section__header--img-h {{ !$isEF?'section__header--img-h-border':'' }}">
                    <img src="/client/images/content/ef.png" class="section__header--img" alt="">
                </div>
                @if(!$isEF)
                    <div class="section__header--img-h">
                        <img src="{{ $model->merchant->getLogo() }}" class="section__header--img" alt="">
                    </div>
                @endif
            </div>
        </div>

        <div class="js--spinner">

            <div class="loading__inner">
                <div class="loading-wrap"></div>
            </div>
            <div class="heading heading--3 text--center">{{ getTranslation('Müraciət göndərilir') }}</div>
            <div class="user-text text--center user-text--mt-15">
                {{ getTranslation('Xahiş edirik, səhifəni bağlamayın və ya tərk etməyin.') }}
            </div>
            <div class="user-text text--center">
                {{ getTranslation('Bir neçə dəqiqə ərzində müraciətinizin nəticəsi barədə sizə məlumat veriləcək.') }}
            </div>
        </div>

        <div class="js--success" style="display:none;">

            <div class="loading__inner">
                <span class="icons icons--success"></span>
            </div>
            <div class="heading heading--3 text--center">{{ getTranslation('Təbriklər! ') }}</div>
            <div class="user-text text--center user-text--mt-15">
                {{ getTranslation('Müraciətiniz göndərildi') }}
            </div>
        </div>

        <div class="js--error" style="display:none;">

            <div class="loading__inner">
                <span class="icons icons--error"></span>
            </div>
            <div class="heading heading--3 text--center">{{ getTranslation('Yenidən cəhd edin') }}</div>

        </div>


    </div>


    <section class="section section__separated--2 js--mainSection">
        <div class="section__separated--item section__separated--item--2">
            <div class="section__separated--item-h">

                <div class="section__header section__header--bordered">
                    <div class="section__header--img-h {{ !$isEF?'section__header--img-h-border':'' }}">
                        <img src="/client/images/content/ef.png" class="section__header--img" alt="">
                    </div>
                    @if(!$isEF)
                        <div class="section__header--img-h">
                            <img src="{{ $model->merchant->getLogo() }}" class="section__header--img" alt="">
                        </div>
                    @endif
                </div>
                <h3 class="heading section__heading heading--2">{{ getTranslation('Video Təlimat') }}</h3>
                <div class="user-text user-text--main">{{ getTranslation('Zəhmət olmasa, aşağıdakı mətni aydın və səlis şəkildə kameraya baxaraq oxuyub video çəkin:') }}</div>

                <div class="user-text user-text--amount-block">
                    {{ getTranslation('Kredit məbləği') }}: <strong>{{ number_format($model->amount, 2) }} AZN</strong>
                </div>

                <div class="section__desc">
                    <span class="icons icons--quote-left section__desc--quote section__desc--quote-left"></span>
                    <span class="icons icons--quote-right section__desc--quote section__desc--quote-right"></span>
                    <div class="user-text user-text--24 user-text--sm-18 user-text--700 user-text--reading">
                        {{ $txtToRead }}
                    </div>
                </div>

                <div class="user-text user-text--list hidden--mobile">
                    <div class="user-text--list-item">{{ getTranslation('Təqdim olunan mətn tam və səlist şəkildə oxunmalıdır.') }}</div>
                    <div class="user-text--list-item">{{ getTranslation('Video çəkilişin müddəti ən azı 10 saniyə olmalıdır.') }}</div>
                    <div class="user-text--list-item">{{ getTranslation('Videoda kənar şəxslər olmamalıdır.') }}</div>
                    <div class="user-text--list-item">
                        {{ getTranslation('Üz görünüşünə təsir edən xarici amillər, zəif işıqlandırma və aşağı keyfiyyətli görüntü olmamalıdır.') }}
                    </div>
                </div>
            </div>

        </div>

        <div class="section__separated--item section__separated--item--2 section__separated--item-gray no--bg-m">
            <div class="section__separated--item-h">
            <div class="video__section">
                <div class="video__h">
                    <div class="video__frame js--videoFrame">
                        <video id="video" autoplay muted></video>
                        <div id="countdown" class="video__countdown"></div>
                    </div>
                    <div class="video__attention js--videoAttention">
                        {{ getTranslation('Need to allow camera to start record') }}
                    </div>
                    <div class="video__preview js--videoPreview">
                        <video id="recordedVideo" class="preview" controls></video>
                    </div>
                </div>
                <div class="video__warning">
                    <span class="video__warning--icon">&#9888;</span>
                    {{ getTranslation('Video çəkiliş zamanı ətrafınızda başqa şəxsin olmadığından əmin olun') }}
                </div>

                <div class="form__btn--group form__btn--group-sm">
                    <button type="button" class="form__btn form__btn--full form__btn--success form__btn--has-icon form__btn--center form__btn--green form__btn--shadow-green js--startRec">
                        {{ getTranslation('Başla') }}
                        <span class="icons icons--rec"></span>
                    </button>
                    <button type="button" style="display:none;" class="form__btn form__btn--sm--2 form__btn--success form__btn--has-icon form__btn--sm form__btn--green form__btn--shadow-green js--restartRec">
                        {{ getTranslation('Yenidən çək') }}
                        <span class="icons icons--rec"></span>
                    </button>
                    <button type="button"
                            style="display:none;"
                            class="form__btn form__btn--main form__btn--has-icon form__btn--md form__btn--sm--2 form__btn--center form__btn--main form__btn--shadow-main js--sendVideo" disabled>
                        {{ getTranslation('Təstiq et') }}
                        <span class="icons icons--arrow-right"></span>
                    </button>
                </div>

                <div class="user-text user-text--list mt--sm-25 hidden--desktop">
                    <div class="user-text--list-item">{{ getTranslation('Təqdim olunan mətn tam və səlist şəkildə oxunmalıdır.') }}</div>
                    <div class="user-text--list-item">{{ getTranslation('Video çəkilişin müddəti ən azı 10 saniyə olmalıdır.') }}</div>
                    <div class="user-text--list-item">{{ getTranslation('Videoda kənar şəxslər olmamalıdır.') }}</div>
                    <div class="user-text--list-item">
                        {{ getTranslation('Üz görünüşünə təsir edən xarici amillər, zəif işıqlandırma və aşağı keyfiyyətli görüntü olmamalıdır.') }}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection
