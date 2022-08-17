<style scoped>
.submit-text {
    font-size: 18px !important;
}

.submit-button {
    display: flex;
    align-items: center;
    justify-content: center;
}

.sc-spinner-small {
    border: 4px solid rgb(255 253 253 / 12%) !important;
    border-top: 4px solid #ffffff !important;
    width: 10px !important;
    height: 10px !important;
}
</style>

<script setup>
const props = defineProps({
    processing: Boolean,
    submitButtonText: String,
});

const emit = defineEmits(['clickAndClose', 'clickAndDonotClose'])

let clickAndCloseAction = () => {
    emit('clickAndClose');
}

let clickAndDonotCloseAction = () => {
    emit('clickAndDonotClose');
}

</script>

<template>
    <div class="uk-margin-top">

        <div class="uk-grid-small" uk-grid>

            <div>
                <button
                    @click="clickAndDonotCloseAction"
                    type="submit"
                    :disabled="processing"
                    class="submit-button sc-button sc-button-large sc-button-primary sc-js-button-wave-light waves-effect waves-button waves-light"
                >

                    <i class="mdi mdi-content-save "></i>&nbsp;
                    <span v-if="submitButtonText">
                    {{ submitButtonText }}
                </span>
                    <span class="submit-text" v-else> {{ $t('save') }} </span>&nbsp;
                    <span v-if="processing" class="sc-spinner sc-spinner-small"></span>

                </button>
            </div>


            <div>
                <button
                    @click="clickAndCloseAction"
                    type="submit"
                    :disabled="processing"
                    class="submit-button sc-button sc-button-large sc-button-primary sc-js-button-wave-light waves-effect waves-button waves-light"
                >

                    <i class="mdi mdi-content-save "></i>&nbsp;
                    <span v-if="submitButtonText">
                    {{ submitButtonText }}
                </span>
                    <span class="submit-text" v-else> {{ $t('save') }} {{ $t('andClose') }} </span>&nbsp;
                    <span v-if="processing" class="sc-spinner sc-spinner-small"></span>

                </button>
            </div>

        </div>


    </div>

</template>

