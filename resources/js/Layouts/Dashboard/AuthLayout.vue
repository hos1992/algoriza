<template>
    <div class="uk-flex uk-flex-center uk-flex-middle sc-login-page-wrapper">
        <div class="uk-width-2-3@s uk-width-1-2@m uk-width-1-3@l uk-width-1-4@xl">
            <div class="uk-card">
                <div class="uk-card-body">
                    <div class="sc-login-page-logo">
                        <img src="/dashboard/assets/img/logo_alt.png" alt="">
                    </div>
                    <div class="sc-login-page-logo sc-login-page-logo-light">
                        <img src="/dashboard/assets/img/logo.png" alt="">
                    </div>

                    <slot/>

                </div>
            </div>
        </div>
    </div>

</template>
