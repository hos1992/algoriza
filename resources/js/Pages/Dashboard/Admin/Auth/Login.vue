<script setup>

import FormBuilder from '@/Components/Dashboard/Forms/FromBuilder.vue';
</script>
<script>
import AuthLayout from "@/Layouts/Dashboard/AuthLayout.vue";


export default {
    layout: AuthLayout
}
</script>

<template>
    <div id="sc-login-form" class="sc-toggle-login-register sc-toggle-login-password">


        <FormBuilder
            form-method="post"
            form-action="/ad/login"
            :form-rows="[
                [{
                    name : 'email',
                    label : 'البريد الألكترونى',
                    type: 'text',
                    value : null,
                 }],
                 [{
                    name : 'password',
                    label : 'كلمة المرور',
                    type: 'password',
                    value : null,
                 }],
            ]"
            submit-button-text="تسجيل دخول "
            :saveAndCloseChoice="false"
            :reset-on-submit="false"
        />

        <!--        <div class="sc-login-page-inner">-->
        <!--            <div class="uk-margin-medium">-->
        <!--                <label for="sc-login-username">Email/Login</label>-->
        <!--                <input id="sc-login-username" type="text" class="uk-input" data-sc-input>-->
        <!--            </div>-->
        <!--            <div class="uk-margin-medium">-->
        <!--                <label for="sc-login-password">Password</label>-->
        <!--                <input id="sc-login-password" type="password" class="uk-input" data-sc-input>-->
        <!--            </div>-->
        <!--            <div class="uk-margin-large-top">-->
        <!--                <a href="dashboard-v1.html"-->
        <!--                   class="sc-button sc-button-large sc-button-block sc-button-danger">Sign In</a>-->
        <!--                <div class="uk-child-width-1-3 uk-grid-medium uk-margin-medium-top" data-uk-grid>-->
        <!--                    <div>-->
        <!--                        <a href="#"-->
        <!--                           class="sc-button sc-button-social sc-button-facebook uk-width-1-1 uk-flex-center"><i-->
        <!--                            class="mdi mdi-facebook"></i></a>-->
        <!--                    </div>-->
        <!--                    <div>-->
        <!--                        <a href="#"-->
        <!--                           class="sc-button sc-button-social sc-button-twitter uk-width-1-1 uk-flex-center"><i-->
        <!--                            class="mdi mdi-twitter"></i></a>-->
        <!--                    </div>-->
        <!--                    <div>-->
        <!--                        <a href="#"-->
        <!--                           class="sc-button sc-button-social sc-button-linkedin uk-width-1-1 uk-flex-center"><i-->
        <!--                            class="mdi mdi-linkedin"></i></a>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="uk-margin-large-top uk-text-center">-->
        <!--                    <span class="sc-color-secondary">Don't have an account?</span>-->
        <!--                    <div><a href="#" class="sc-text-semibold"-->
        <!--                            data-uk-toggle="target: .sc-toggle-login-register; animation: uk-animation-scale-up">Sign-->
        <!--                        Up</a></div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</template>
