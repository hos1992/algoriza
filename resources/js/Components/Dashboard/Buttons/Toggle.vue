<style>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #2196f3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196f3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
<script setup>
import {onMounted, onUpdated, ref, watch} from "vue";
import {createToast} from "mosha-vue-toastify";
import {Inertia} from "@inertiajs/inertia";


let currentValue = ref(props.value);

const props = defineProps({
    id: [String, Number],
    value: [Boolean, Number],
    toggleUrl: String,
    modalTitle: {
        type: String,
        default: 'تأكيد تغير الحالة'
    },
});
const emit = defineEmits(["statusChanged"]);

let changeEvent = () => {

    UIkit.modal.confirm(props.modalTitle, {
        labels: {
            cancel: 'إلغاء',
            ok: 'نعم'
        }
    }).then(function () {


        Inertia.post(props.toggleUrl, {}, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onSuccess: response => {

                createToast(' تم تحديث الحالة بنجاح ', {
                    position: 'top-left',
                    type: 'success',
                    // hideProgressBar: 'true',
                    transition: 'bounce',
                    // toastBackgroundColor: '#2e7d32',
                    showIcon: true,
                });

            },
            onError: error => {
                createToast(' خطأ فى معالجة البيانات ! ', {
                    position: 'top-left',
                    type: 'danger',
                    // hideProgressBar: 'true',
                    transition: 'bounce',
                    // toastBackgroundColor: '#2e7d32',
                    showIcon: true,
                });

                currentValue.value = props.value;

            }
        });


    }, function () {
        currentValue.value = props.value;
    })


}

</script>
<template>
    <label class="switch">
        <input
            type="checkbox"
            :checked="currentValue"
            @click="changeEvent"
            @change=" currentValue ? (currentValue = false) : (currentValue = true)"
        />
        <span class="slider round"></span>
    </label>
</template>
