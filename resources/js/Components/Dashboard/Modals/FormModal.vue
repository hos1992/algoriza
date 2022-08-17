<script setup>
import axios from "axios";
import {ref} from "vue";
import FromBuilder from "../Forms/FromBuilder.vue";

let formAction = ref("");
let formMethod = ref("");
let formRows = ref([]);

const props = defineProps({
    id: String,
    icon: String,
    buttonText: String,
    buttonclass: {
        type: String,
        default: "sc-button-primary",
    },
    modalTitle: String,
    openActionUrl: String,
    saveAndCloseChoice: {
        type: Boolean,
        default: true,
    },
});

let openAction = () => {
    axios.get(props.openActionUrl).then((response) => {
        formAction.value = response.data?.formAction;
        formMethod.value = response.data?.formMethod;
        formRows.value = response.data?.formRows ?? {};
    });
};

// code to watch the modal open & close state
setTimeout(function () {
    var modal = document.getElementById(props.id);
    var observer = new MutationObserver(function () {
        // reset form builder values on close
        if (modal.style.display != "block") {
            formRows.value = [];
            formAction.value = "";
            formMethod.value = "";
        }
    });
    observer.observe(modal, {attributes: true, childList: true});
}, 200);
</script>
<template>
    <a
        :class="
      'sc-button ' +
      buttonclass +
      ' sc-button-icon sc-js-button-wave-light waves-effect waves-button waves-light'
    "
        :href="'#' + id"
        data-uk-toggle
        @click="openAction"
    >
        <span v-if="icon" :data-uk-icon="'icon:' + icon"></span>&nbsp;
        <span v-if="buttonText">
      {{ buttonText }}
    </span>
    </a>
    <teleport to="body">
        <div :id="id" data-uk-modal>
            <div class="uk-modal-dialog">
                <button
                    class="uk-modal-close-default"
                    type="button"
                    data-uk-close
                ></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">
                        {{ modalTitle ?? buttonText }}
                    </h2>
                </div>
                <div class="uk-modal-body">
                    <FromBuilder
                        v-if="formRows.length"
                        :form-action="formAction"
                        :form-method="formMethod"
                        :form-rows="formRows"
                        :saveAndCloseChoice="saveAndCloseChoice"
                    />
                    <div v-else class="uk-text-center">
                        <div class="sc-spinner sc-spinner-large"></div>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>
