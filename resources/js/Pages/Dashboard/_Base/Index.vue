<style scoped>
.table-height {
    max-height: 45vh;
}

.actions-cell {
    min-width: 150px;
}

.actions-cell a {
    margin-left: 2px;
    margin-right: 2px;
}

table th,
table td {
    border: 1px solid #e5e5e5;
}
</style>

<script setup>
import Breadcrumb from "@/Components/Dashboard/Main/Breadcrumb.vue";
import Pagination from "@/Components/Dashboard/Main/Pagination.vue";
import FormModal from "@/Components/Dashboard/Modals/FormModal.vue";
import EditFormModal from "@/Components/Dashboard/Modals/EditFormModal.vue";
import ConfirmModal from "@/Components/Dashboard/Modals/ConfirmModal.vue";
import Badge from "@/Components/Dashboard/Main/Badge.vue";
import FilterFormBuilder from "@/Components/Dashboard/Forms/FilterFormBuilder.vue";
import {ref} from "vue";
import axios from "axios";
import Toggle from "@/Components/Dashboard/Buttons/Toggle.vue";

const props = defineProps({
    data: Object,
});

let editFormAction = ref("");
let editFormMethod = ref("");
let editFormRows = ref([]);

let editFormModal = ref({
    id: "edit_form",
    resetOnSubmit: false,
});

let openEditFormAction = (url) => {
    editFormAction.value = "";
    editFormMethod.value = "";
    editFormRows.value = [];
    setTimeout(function () {
        axios.get(url).then((response) => {
            editFormAction.value = response.data?.formAction;
            editFormMethod.value = response.data?.formMethod;
            editFormRows.value = response.data?.formRows ?? {};
        });
    }, 100);
};

let confirmModal = ref({
    id: "confirm_modal",
    modalTitle: "",
    url: "",
    redirectUrl: "",
});

let openConfirmModalAction = (url, redirectUrl, modalTitle) => {
    confirmModal.value.url = url;
    confirmModal.value.redirectUrl = redirectUrl;
    if (modalTitle) {
        confirmModal.value.modalTitle = modalTitle;
    }
};

</script>
<template>
    <!-- Breadcrumb -->
    <Breadcrumb
        v-if="data.breadcrumb"
        :heading="data.breadcrumb?.heading"
        :headingUrl="data.breadcrumb?.headingUrl"
        :tree="data.breadcrumb?.tree"
    />

    <div id="sc-page-content">
        <!--    check on this div if there's more than one button with || ( data.rules?.canAdd || new button rule )   -->
        <div v-if="data.rules?.canAdd" class="uk-card">
            <div class="uk-card-body">
                <template v-if="data.rules?.canAdd">
                    <!-- Add New Modal -->
                    <FormModal
                        v-if="data.config?.add_in_modal"
                        :id="data.config?.add_button_id"
                        icon="plus-circle"
                        :buttonText="data.config?.add_button_text"
                        :modalTitle="data.config?.add_modal_title"
                        :openActionUrl="data.config?.links?.modal_add_new_url"
                        :save-and-close-choice="
                        data.config?.add_modal_submit_and_close_option"
                    />

                    <!-- Add new Page -->
                    <Link
                        v-else
                        :href="data.config?.links?.page_add_new_url"
                        class="sc-button sc-button-primary sc-button-icon sc-js-button-wave-light
                          waves-effect waves-button waves-light
                        "
                    >
                        <span data-uk-icon="icon: plus-circle;"></span>

                        <span v-if="data.config?.add_button_text">
                          &nbsp; {{ data.config?.add_button_text }}
                        </span>
                    </Link>


                </template>
            </div>
        </div>

        <div class="uk-card uk-margin-top">
            <!-- <h3 class="uk-card-title">admins</h3> -->

            <div class="uk-card-header">
                <!-- the filter form -->

                <template v-if="data.filterForm">
                    <FilterFormBuilder
                        :form-method="data.filterForm?.method"
                        :form-action="data.filterForm?.action"
                        :form-rows="data.filterForm?.rows"
                    />
                </template>

                <!-- the index table options "export to excel ot print" -->
            </div>

            <div class="uk-card-body">
                <div class="uk-overflow-auto table-height">
                    <table
                        v-if="data.rules?.canIndex"
                        class="uk-table uk-table-hover uk-table-divider uk-table-condensed"
                    >
                        <thead>
                        <tr>
                            <th class="uk-text-nowrap uk-text-bold">#</th>
                            <th
                                v-for="(item, key) in data.tableHeaders"
                                class="uk-text-nowrap uk-text-bold"
                                :key="key"
                            >
                                {{ item.displayName }}
                            </th>
                            <th class="uk-text-nowrap uk-text-bold">
                                {{ $t("actions") }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(model, index) in data.collection.data ??
                data.collection"
                            :key="model['id']"
                        >
                            <td>{{ index + 1 }}</td>
                            <template
                                v-for="(item, key) in data.tableHeaders"
                                :key="key + model['id']"
                            >
                                <!--// TEXT-->
                                <td v-if="item['type'] === 'text'">{{ model[key] }}</td>

                                <!--// IMAGE-->
                                <!-- <td v-if="item['type'] === 'image'">
                                                                          <IndexImage :src="model[key]" alt="thumb-image" />
                                                                        </td> -->

                                <!--// BADGE-->
                                <td v-if="item['type'] === 'badge'">
                                    <Badge :text="model[key]"/>
                                </td>

                                <!--// Toggle-->
                                <td v-if="item['type'] === 'toggle'">
                                    <Toggle
                                        :id="model['id']"
                                        :value="model[key]"
                                        :toggle-url="model[item['toggleUrlAttr']]"
                                        :modal-title="item['toggleModalTitle']"
                                    />
                                </td>


                                <!--// Icon-->
                                <!-- <td v-if="item['type'] === 'icon'">
                                                                          <IndexIcon :icon="model[key]" />
                                                                        </td> -->

                                <!--// BUTTON -->
                                <!-- <td v-if="item['type'] === 'button'">
                                                                          <IndexButton
                                                                            :url="model[item['buttonUrlAttr']]"
                                                                            :icon="item['icon']"
                                                                            :text="item['text']"
                                                                            :btn-class="item['btnClass'] ?? 'btn-primary'"
                                                                          />
                                                                        </td> -->
                            </template>

                            <td class="actions-cell">
                                <template v-if="data.rules?.canEdit">
                                    <!--  Edit modal url -->
                                    <a
                                        v-if="data.config?.edit_in_modal"
                                        class="
                        sc-button sc-button-custom
                        md-bg-blue-500
                        sc-button-icon sc-js-button-wave-light
                        waves-effect waves-button waves-light
                      "
                                        :href="'#' + editFormModal.id"
                                        data-uk-toggle
                                        @click.prevent="
                        openEditFormAction(
                          model['actions_urls']['edit'] + '?forModal=1'
                        )
                      "
                                    >
                                        <span data-uk-icon="icon: file-edit"></span>&nbsp;
                                    </a>

                                    <!-- Edit page Url-->
                                    <Link
                                        v-else
                                        :href="model['actions_urls']['edit']"
                                        class="
                        sc-button sc-button-custom
                        md-bg-blue-500
                        sc-button-icon sc-js-button-wave-light
                        waves-effect waves-button waves-light
                      "
                                    >
                                        <span data-uk-icon="icon: file-edit"></span>
                                    </Link>
                                </template>

                                <!--      Delete Modal        -->
                                <template v-if="data.rules?.canDelete">
                                    <a
                                        class="
                        sc-button sc-button-custom
                        md-bg-red-500
                        sc-button-icon sc-js-button-wave-light
                        waves-effect waves-button waves-light
                      "
                                        :href="'#' + confirmModal.id"
                                        data-uk-toggle
                                        @click.prevent="
                        openConfirmModalAction(
                          model['actions_urls']['delete'],
                          model['actions_urls']['index'],
                          $t('confirmDelete')
                        )
                      "
                                    >
                                        <span data-uk-icon="icon: trash"></span>&nbsp;
                                    </a>
                                </template>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <Pagination
            v-if="data.collection.links"
            :links="data.collection.meta.links"
            :meta="data.collection.meta"
        />

        <EditFormModal
            :id="editFormModal.id"
            :resetOnSubmit="editFormModal.resetOnSubmit"
            :form-action="editFormAction"
            :form-method="editFormMethod"
            :form-rows="editFormRows"
            :saveAndCloseChoice="data.config?.edit_modal_submit_and_close_option"
        />

        <confirmModal
            :id="confirmModal.id"
            :modalTitle="confirmModal.modalTitle"
            :onConfirmUrl="confirmModal.url"
            :redirectUrl="confirmModal.redirectUrl"
        />
    </div>
</template>
