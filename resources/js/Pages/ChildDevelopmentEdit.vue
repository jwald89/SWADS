<script setup>
import { defineComponent, watchEffect, reactive } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { toast } from "vue3-toastify";
import vSelect from "vue-select";

const props = defineProps({
    childData: Object,
    barangays: Object,
    municipalities: Object,
});

const errors = reactive({});

const submitForm = async () => {
    try {
        const response = await axios.put(
            `/child-development/update/${props.childData.id}`,
            props.childData
        );

        toast.success("Record successfully updated.", {
            autoClose: 1000,
        });

        console.log("working..");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
                }
            }
            toast.error("Please fill in the blanks error!", {
                autoClose: 2000,
            });
        }
        console.error("Error submitting form:", error);
    }
};

watchEffect(() => {
    props.childData.municipality = parseInt(props.childData.municipality);
    props.childData.barangay = parseInt(props.childData.barangay);
});

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
                        <h5 class="fw-bold">
                            <i class="bi bi-pen-fill"></i>
                            Edit Record
                            <small class="font-monospace"
                                >(Child Development Form)</small
                            >
                        </h5>
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
                                            class="form-control form-control-md"
                                            name="cdc"
                                            v-model="childData.cdc_name"
                                            placeholder="Child Development Center.."
                                        />
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
                                            class="form-control form-control-md"
                                            name="dateEncoded"
                                        />
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
                                            class="form-control form-control-md"
                                            name="purok"
                                            v-model="childData.purok"
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
                                            :options="municipalities.data"
                                            :reduce="(data) => data.id"
                                            v-model="childData.municipality"
                                            label="municipality"
                                            placeholder="Select"
                                        >
                                        </v-select>
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
                                            :options="barangays.data"
                                            :reduce="(data) => data.id"
                                            v-model="childData.barangay"
                                            label="barangay"
                                            placeholder="Select"
                                        >
                                        </v-select>
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="sitio"
                                            class="font-monospace fw-bold"
                                            >Sitio</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="sitio"
                                            v-model="childData.sitio"
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
                                            class="form-control form-control-md"
                                            name="cdw"
                                            v-model="childData.cdw_name"
                                            placeholder="Child Development Worker.."
                                        />
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
                                            class="form-control form-control-md"
                                            name="validity"
                                            v-model="childData.validity_of_cor"
                                        />
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
                                            class="form-control form-control-md"
                                            name="status"
                                            v-model="childData.status"
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
                                            v-model="childData.lvl_recognition"
                                        >
                                            <option value="" disabled>
                                                Select
                                            </option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                            <option value="V">V</option>
                                        </select>
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
                                            class="form-control form-control-md"
                                            name="noChildren"
                                            v-model="
                                                childData.no_entered_children
                                            "
                                        />
                                    </div>

                                    <div class="col-12 col-md-3 mb-3">
                                        <label
                                            for="feedingRecep"
                                            class="font-monospace fw-bold"
                                            >No. of Feeding Recepients<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="feedingRecep"
                                            v-model="
                                                childData.no_feed_recepients
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-md btn-success mt-3"
                            >
                                <i class="bi bi-save"></i>
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
