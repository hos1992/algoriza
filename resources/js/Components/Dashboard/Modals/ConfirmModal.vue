<style>
.sc-spinner-small {
    border: 4px solid rgb(255 253 253 / 12%) !important;
    border-top: 4px solid #ffffff !important;
    width: 10px !important;
    height: 10px !important;
    vertical-align: inherit;
}
</style>

<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import {onMounted, onUpdated, ref} from "vue";
import {createToast} from "mosha-vue-toastify";
import {Inertia} from "@inertiajs/inertia";

let onConfirmUrl = ref("");
let redirectUrl = ref("");

const props = defineProps({
    id: String,
    modalTitle: {
        type: String,
        default: "تأكيد",
    },
    onConfirmUrl: String,
    redirectUrl: String,
});

onMounted(() => {
    onConfirmUrl.value = props.onConfirmUrl;
    redirectUrl.value = props.redirectUrl;
    form.redirectUrl = props.redirectUrl;
});

onUpdated(() => {
    onConfirmUrl.value = props.onConfirmUrl;
    redirectUrl.value = props.redirectUrl;
    form.redirectUrl = props.redirectUrl;
});

let form = useForm({
    _method: "delete",
    redirectUrl: redirectUrl.value,
});

let formSubmit = () => {
    form.post(onConfirmUrl.value, {
        onSuccess: () => {
            document.getElementsByClassName("close-confirm")[0].click();
            createToast(" تم تحديث البيانات بنجاح ", {
                position: "top-left",
                type: "success",
                // hideProgressBar: 'true',
                transition: "bounce",
                // toastBackgroundColor: '#2e7d32',
                showIcon: "true",
            });
        },
    });
};

// code to watch the modal open & close state
setTimeout(function () {
    var modal = document.getElementById(props.id);
    var observer = new MutationObserver(function () {
        // reset form builder values on close
        if (modal.style.display != "block") {
            onConfirmUrl.value = "";
            redirectUrl.value = "";
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
                    <div v-if="onConfirmUrl">
                        <button
                            class="uk-button uk-button-default uk-modal-close close-confirm"
                            type="button"
                        >
                            {{ $t("cancel") }}
                        </button>
                        <button
                            @click.prevent="formSubmit"
                            :disabled="form.processing"
                            class="uk-button uk-button-primary"
                            autofocus=""
                        >
                            <span> {{ $t("yes") }} </span>&nbsp;
                            <span
                                v-if="form.processing"
                                class="sc-spinner sc-spinner-small"
                            ></span>
                        </button>
                    </div>
                    <div v-else class="uk-text-center">
                        <div class="sc-spinner sc-spinner-large"></div>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>
