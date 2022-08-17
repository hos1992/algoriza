<script setup>
// import {useI18n} from 'vue-i18n';
// const {t} = useI18n();
import FromBuilder from "@/Components/Dashboard/Forms/FromBuilder.vue";
import {computed, onMounted, onUpdated, ref} from "vue";

let formAction = ref("");
let formMethod = ref("");
let formRows = ref([]);


const props = defineProps({
    id: {
        type: String,
        default: 'edit_form',
    },
    modalTitle: {
        type: String,
        default: 'تعديل',
    },
    formRows: Array,
    formAction: String,
    formMethod: String,
    resetOnSubmit: {
        type: Boolean,
        default: false,
    },
    saveAndCloseChoice: Boolean,
});

onMounted(() => {
    formAction.value = props.formAction;
    formMethod.value = props.formMethod;
    formRows.value = props.formRows;
});

onUpdated(() => {
    formAction.value = props.formAction;
    formMethod.value = props.formMethod;
    formRows.value = props.formRows;
});

// code to watch the modal open & close state
setTimeout(function () {
    var modal = document.getElementById(props.id);
    var observer = new MutationObserver(function () {
        // reset form builder values on close
        if (modal.style.display !== "block") {
            formRows.value = [];
            formAction.value = "";
            formMethod.value = "";
        }
    });
    observer.observe(modal, {attributes: true, childList: true});
}, 200);
</script>
<template>
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
                        {{ modalTitle }}
                    </h2>
                </div>
                <div class="uk-modal-body">
                    <FromBuilder
                        v-if="formRows.length"
                        :resetOnSubmit="resetOnSubmit"
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
