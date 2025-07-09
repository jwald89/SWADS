<script setup>
import { defineComponent, reactive, ref, computed, watch } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { toast } from "vue3-toastify";
import vSelect from "vue-select";

const props = defineProps({
    barangays: {
        type: Object,
        required: true,
    },
    municipality: {
        type: Object,
        required: true,
    },
});

const errors = reactive({});
const isSubmitting = ref(false);

const childDevForm = reactive({
    cdc_name: "",
    date_encoded: "",
    municipality: "",
    barangay: "",
    purok: "",
    sitio: "",
    cdw_name: "",
    status: "",
    lvl_recognition: "",
    validity_of_cor: "",
    no_entered_children: "",
    no_feed_recepients: "",
});

const barangayOptions = computed(() => {
    if (!childDevForm.municipality) return [];

    const list = Array.isArray(props.barangays)
        ? props.barangays
        : props.barangays?.data ?? [];

    return list.filter(
        (b) => Number(b.municipality_id) === Number(childDevForm.municipality)
    );
});

watch(
    () => childDevForm.municipality,
    () => {
        childDevForm.barangay == null;
    }
);

const resetForm = () => {
    childDevForm.cdc_name = "";
    childDevForm.date_encoded = "";
    childDevForm.purok = "";
    childDevForm.municipality = "";
    childDevForm.barangay = "";
    childDevForm.cdw_name = "";
    childDevForm.status = "";
    childDevForm.lvl_recognition = "";
    childDevForm.validity_of_cor = "";
    childDevForm.no_entered_children = "";
    childDevForm.no_feed_recepients = "";
    childDevForm.sitio = "";
};

const submitForm = async () => {
    // Clear previous errors
    const fields = [
        "cdc_name",
        "date_encoded",
        "purok",
        "barangay",
        "municipality",
        "cdw_name",
        "status",
        "lvl_recognition",
        "validity_of_cor",
        "no_entered_children",
        "no_feed_recepients",
        "sitio",
    ];

    fields.forEach((field) => {
        if (childDevForm[field]) {
            errors[field] = "";
        }
    });

    isSubmitting.value = true;

    try {
        const response = await axios.post(
            "/child-development/post",
            childDevForm
        );

        toast.success("Successfully created.", {
            autoClose: 1000,
        });

        console.log("working..");
        resetForm();
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
                }
            }
            toast.error("Please check the error in fields!", {
                autoClose: 2000,
            });
        }
        console.error("Error submitting form:", error);
    } finally {
        isSubmitting.value = false;
    }
};

defineComponent({
    vSelect,
});
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Child Development Form</h5>
                    </div>
                    <div class="col-lg-6 text-end">
                        <Link
                            class="btn btn-sm btn-light"
                            :href="`/child-development`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form @submit.prevent="submitForm">
                    <div>
                        <h6>
                            <i class="bi bi-credit-card-2-front-fill"></i>
                            Information
                        </h6>
                        <div class="card">
                            <div class="card-body p-3">
                                <div
                                    class="d-flex flex-column flex-md-row justify-content-between mt-2"
                                >
                                    <div class="col-12 col-md-6 mb-3">
                                        <label
                                            for="cdc"
                                            class="font-monospace fw-bold"
                                            >Name of CDC<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="cdc"
                                            v-model="childDevForm.cdc_name"
                                            placeholder="Child Development Center.."
                                            :class="{
                                                'is-invalid': errors.cdc_name,
                                            }"
                                        />
                                        <small
                                            v-if="errors.cdc_name"
                                            class="text-danger"
                                            >{{ errors.cdc_name }}</small
                                        >
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="dateEncoded"
                                            class="font-monospace fw-bold"
                                            >Date Encoded<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="date"
                                            class="form-control"
                                            name="dateEncoded"
                                            v-model="childDevForm.date_encoded"
                                            :class="{
                                                'is-invalid':
                                                    errors.date_encoded,
                                            }"
                                        />
                                        <small
                                            v-if="errors.date_encoded"
                                            class="text-danger"
                                            >{{ errors.date_encoded }}</small
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6><i class="bi bi-house-fill"></i> Address</h6>
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="purok"
                                            class="font-monospace fw-bold"
                                            >Purok</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="purok"
                                            v-model="childDevForm.purok"
                                        />
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="municipality"
                                            class="font-monospace fw-bold"
                                            >Municipality<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <v-select
                                            name="municipality"
                                            id="municipality"
                                            :options="municipality.data"
                                            :reduce="(data) => data.id"
                                            v-model="childDevForm.municipality"
                                            label="municipality"
                                            :class="{
                                                'is-invalid':
                                                    errors.municipality,
                                            }"
                                            placeholder="Select"
                                        />
                                        <small
                                            v-if="errors.municipality"
                                            class="text-danger"
                                            >{{ errors.municipality }}</small
                                        >
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="barangay"
                                            class="font-monospace fw-bold"
                                            >Barangay<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <v-select
                                            name="barangay"
                                            id="barangay"
                                            :options="barangayOptions"
                                            :reduce="(data) => data.id"
                                            v-model="childDevForm.barangay"
                                            label="barangay"
                                            placeholder="Select"
                                            :class="{
                                                'is-invalid': errors.barangay,
                                            }"
                                            :disabled="
                                                !childDevForm.municipality
                                            "
                                        />
                                        <small
                                            v-if="errors.barangay"
                                            class="text-danger"
                                            >{{ errors.barangay }}</small
                                        >
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="sitio"
                                            class="font-monospace fw-bold"
                                            >Sitio</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="sitio"
                                            v-model="childDevForm.sitio"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6><i class="bi bi-file-text-fill"></i> Others</h6>
                        <div class="card">
                            <div class="card-body p-3">
                                <div
                                    class="d-flex flex-column flex-md-row justify-content-between mt-2"
                                >
                                    <div class="col-12 col-md-6 mb-3">
                                        <label
                                            for="cdw"
                                            class="font-monospace fw-bold"
                                            >Name of CDW<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="cdw"
                                            v-model="childDevForm.cdw_name"
                                            placeholder="Child Development Worker.."
                                            :class="{
                                                'is-invalid': errors.cdw_name,
                                            }"
                                        />
                                        <small
                                            v-if="errors.cdw_name"
                                            class="text-danger"
                                            >{{ errors.cdw_name }}</small
                                        >
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="validity"
                                            class="font-monospace fw-bold"
                                            >Validity of Certificate of
                                            Recognition<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="date"
                                            class="form-control"
                                            name="validity"
                                            v-model="
                                                childDevForm.validity_of_cor
                                            "
                                            :class="{
                                                'is-invalid':
                                                    errors.validity_of_cor,
                                            }"
                                        />
                                        <small
                                            v-if="errors.validity_of_cor"
                                            class="text-danger"
                                            >{{ errors.validity_of_cor }}</small
                                        >
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="status"
                                            class="font-monospace fw-bold"
                                            >Status</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="status"
                                            v-model="childDevForm.status"
                                        />
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="level"
                                            class="font-monospace fw-bold"
                                            >Level of Recognition<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            class="form-select"
                                            name="level"
                                            id="level"
                                            v-model="
                                                childDevForm.lvl_recognition
                                            "
                                            :class="{
                                                'is-invalid':
                                                    errors.lvl_recognition,
                                            }"
                                        >
                                            <option
                                                class="text-muted"
                                                value=""
                                                disabled
                                            >
                                                Select
                                            </option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                            <option value="V">V</option>
                                        </select>
                                        <small
                                            v-if="errors.lvl_recognition"
                                            class="text-danger"
                                            >{{ errors.lvl_recognition }}</small
                                        >
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="noChildren"
                                            class="font-monospace fw-bold"
                                            >No. of Entered Children<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="noChildren"
                                            v-model="
                                                childDevForm.no_entered_children
                                            "
                                            :class="{
                                                'is-invalid':
                                                    errors.no_entered_children,
                                            }"
                                        />
                                        <small
                                            v-if="errors.no_entered_children"
                                            class="text-danger"
                                            >{{
                                                errors.no_entered_children
                                            }}</small
                                        >
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="feedingRecep"
                                            class="font-monospace fw-bold"
                                            >No. of Feeding Recipients<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="feedingRecep"
                                            v-model="
                                                childDevForm.no_feed_recepients
                                            "
                                            :class="{
                                                'is-invalid':
                                                    errors.no_feed_recepients,
                                            }"
                                        />
                                        <small
                                            v-if="errors.no_feed_recepients"
                                            class="text-danger"
                                            >{{
                                                errors.no_feed_recepients
                                            }}</small
                                        >
                                    </div>
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-md btn-success mt-3"
                            >
                                <i class="bi bi-save"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
