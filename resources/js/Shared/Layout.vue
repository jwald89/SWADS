<script setup>
import { onMounted, ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import axios from "axios";

const toggleSidebar = () => {
    document.body.classList.toggle("toggle-sidebar");
};

const page = usePage();
const currentRoute = ref("");

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};

const logout = () => {
    try {
        axios.post(`/logout`).then((response) => {
            window.location.href = "/login-page";
        });
    } catch (error) {
        errorMessage.value = "An error occurred during logout.";
        console.error("Error during logout:", error);
    }
};

onMounted(() => {
    currentRoute.value = location.pathname;

    // Attach event listener for the toggle sidebar button
    const toggleButton = document.querySelector(".toggle-sidebar-btn");
    if (toggleButton) {
        toggleButton.addEventListener("click", toggleSidebar);
    }
});
</script>

<template>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <div class="logo d-flex align-items-center">
                <img
                    src="/public/assets/img/pdms-logo.png"
                    width="200px"
                    class="ms-4"
                    style="max-height: 55px"
                />
            </div>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a
                        class="nav-link nav-profile d-flex align-items-center pe-0"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-person-circle"></i>
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2 text-uppercase"
                        >
                            {{ page.props.fullname }}
                            {{ page.props.middle_init.substr(0, 1) + "." }}
                        </span>
                    </a>

                    <ul
                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                    >
                        <li class="dropdown-header">
                            <i class="bi bi-person-bounding-box"></i>
                            <h6 class="text-uppercase">
                                {{ page.props.last_name }}
                            </h6>
                            <span>{{ page.props.role_type }}</span>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li>
                            <button
                                @click="logout"
                                class="dropdown-item d-flex align-items-center"
                            >
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Log Out</span>
                            </button>
                        </li>
                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->
            </ul>
        </nav>
        <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <div class="mb-4 mt-0 text-center">
            <img src="/public/assets/img/sds.png" alt="" width="80px" />
        </div>

        <ul class="sidebar-nav" id="sidebar-nav">
            <!-- Admin Dashboard -->
            <li class="nav-item" v-if="hasAccess(['admin', 'supervisor'])">
                <Link
                    class="nav-link"
                    :href="`/dashboard`"
                    :class="{
                        'bg-highlight': currentRoute.includes('dashboard'),
                    }"
                >
                    <i
                        class="bi bi-grid"
                        :class="{
                            'color-highlight':
                                currentRoute.includes('dashboard'),
                        }"
                    ></i>
                    <span
                        :class="{
                            'color-highlight':
                                currentRoute.includes('dashboard'),
                        }"
                        >DASHBOARD</span
                    >
                </Link>
            </li>

            <!-- User Dashboard -->
            <li class="nav-item" v-if="hasAccess(['user'])">
                <Link
                    class="nav-link"
                    :href="`/user/dashboard`"
                    :class="{
                        'bg-highlight': currentRoute.includes('user/dashboard'),
                    }"
                >
                    <i
                        class="bi bi-grid"
                        :class="{
                            'color-highlight':
                                currentRoute.includes('user/dashboard'),
                        }"
                    ></i>
                    <span
                        :class="{
                            'color-highlight':
                                currentRoute.includes('user/dashboard'),
                        }"
                        >DASHBOARD</span
                    >
                </Link>
            </li>

            <!-- Municipality Dashboard -->
            <li class="nav-item" v-if="hasAccess(['municipal'])">
                <Link
                    class="nav-link"
                    :href="`/municipal/dashboard`"
                    :class="{
                        'bg-highlight': currentRoute.includes(
                            'municipal/dashboard'
                        ),
                    }"
                >
                    <i
                        class="bi bi-grid"
                        :class="{
                            'color-highlight': currentRoute.includes(
                                'municipal/dashboard'
                            ),
                        }"
                    ></i>
                    <span
                        :class="{
                            'color-highlight': currentRoute.includes(
                                'municipal/dashboard'
                            ),
                        }"
                        >DASHBOARD</span
                    >
                </Link>
            </li>
            <!-- End Dashboard Nav -->

            <!-- AICS MODULE -->
            <!-- ADMIN ROLE ACCESS -->
            <div v-if="hasAccess(['admin', 'supervisor'])">
                <li class="nav-heading">AICS</li>

                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :href="`/intake`"
                        :class="{
                            'bg-highlight': currentRoute.includes('intake'),
                        }"
                    >
                        <i
                            class="bi bi-file-text"
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('intake'),
                            }"
                        ></i>
                        <span
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('intake'),
                            }"
                            >INTAKE SHEET</span
                        >
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :href="`/monitoring`"
                        :class="{
                            'bg-highlight': currentRoute.includes('monitoring'),
                        }"
                    >
                        <i
                            class="bi bi-receipt-cutoff"
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('monitoring'),
                            }"
                        ></i>
                        <span
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('monitoring'),
                            }"
                            >MONITORING</span
                        >
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :href="`/sectoral-data`"
                        :class="{
                            'bg-highlight':
                                currentRoute.includes('sectoral-data'),
                        }"
                    >
                        <i
                            class="bi bi-journal"
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('sectoral-data'),
                            }"
                        ></i>
                        <span
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('sectoral-data'),
                            }"
                            >SECTORAL DATA</span
                        >
                    </Link>
                </li>
            </div>
            <!-- END ADMIN ROLE -->

            <!-- LIAISON ROLE ACCESS -->
            <li class="nav-item" v-if="hasAccess(['liaison'])">
                <Link
                    class="nav-link"
                    :href="`/monitoring`"
                    :class="{
                        'bg-highlight': currentRoute.includes('monitoring'),
                    }"
                >
                    <i
                        class="bi bi-receipt-cutoff"
                        :class="{
                            'color-highlight':
                                currentRoute.includes('monitoring'),
                        }"
                    ></i>
                    <span
                        :class="{
                            'color-highlight':
                                currentRoute.includes('monitoring'),
                        }"
                        >MONITORING</span
                    >
                </Link>
            </li>
            <!-- END LIAISON ROLE -->

            <!-- MUNICIPAL ROLE ACCESS -->
            <div v-if="hasAccess(['municipal'])">
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :href="`/sectoral-data`"
                        :class="{
                            'bg-highlight':
                                currentRoute.includes('sectoral-data'),
                        }"
                    >
                        <i
                            class="bi bi-journal"
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('sectoral-data'),
                            }"
                        ></i>
                        <span
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('sectoral-data'),
                            }"
                            >SECTORAL DATA</span
                        >
                    </Link>
                </li>
            </div>
            <!-- END MUNICIPAL ROLE -->

            <!-- OTHERS SECTION -->
            <div v-if="hasAccess(['admin', 'supervisor'])">
                <li class="nav-heading">OTHERS</li>
                <!-- CHILD DEVELOPMENT MODULE -->
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :href="`/child-development`"
                        :class="{
                            'bg-highlight':
                                currentRoute.includes('child-development'),
                        }"
                    >
                        <i
                            class="bi bi-badge-cc"
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('child-development'),
                            }"
                        ></i>
                        <span
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('child-development'),
                            }"
                            >CHILD DEVELOPMENT</span
                        >
                    </Link>
                </li>
                <!-- END OF CHILD DEVELOPMENT MODULE -->

                <!-- MEDICAL MODULE -->
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :href="`/medicine`"
                        :class="{
                            'bg-highlight': currentRoute.includes('medicine'),
                        }"
                    >
                        <i
                            class="bi bi-file-earmark-medical"
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('medicine'),
                            }"
                        ></i>
                        <span
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('medicine'),
                            }"
                            >MEDICINE</span
                        >
                    </Link>
                </li>
                <!-- END OF MEDICAL MODULE -->

                <!-- TRANSACTION MODULE -->
                <!-- <li class="nav-item">
                    <Link class="nav-link">
                        <i class="bi bi-file-post-fill"></i>
                        <span>TRANSACTION</span>
                    </Link>
                </li> -->
                <!-- END OF TRANSACTION MODULE -->

                <a
                    class="nav-link collapsed"
                    data-bs-target="#components-nav-2"
                    data-bs-toggle="collapse"
                    :class="{
                        'bg-highlight':
                            currentRoute.includes('user-registration/index') ||
                            currentRoute.includes('type-assistance') ||
                            currentRoute.includes('sectors') ||
                            currentRoute.includes('office-charges') ||
                            currentRoute.includes('relationship'),
                    }"
                >
                    <i
                        class="bi bi-gear"
                        :class="{
                            'text-primary':
                                currentRoute.includes(
                                    'user-registration/index'
                                ) ||
                                currentRoute.includes('type-assistance') ||
                                currentRoute.includes('sectors') ||
                                currentRoute.includes('office-charges') ||
                                currentRoute.includes('relationship'),
                        }"
                    ></i>
                    <span
                        :class="{
                            'color-highlight':
                                currentRoute.includes(
                                    'user-registration/index'
                                ) ||
                                currentRoute.includes('type-assistance') ||
                                currentRoute.includes('sectors') ||
                                currentRoute.includes('office-charges') ||
                                currentRoute.includes('relationship'),
                        }"
                        >MAINTENANCE</span
                    >
                    <i
                        class="bi bi-chevron-down ms-auto"
                        :class="{
                            'text-primary':
                                currentRoute.includes(
                                    'user-registration/index'
                                ) ||
                                currentRoute.includes('type-assistance') ||
                                currentRoute.includes('sectors') ||
                                currentRoute.includes('office-charges') ||
                                currentRoute.includes('relationship'),
                        }"
                    ></i>
                </a>
                <ul
                    id="components-nav-2"
                    class="nav-content collapse"
                    :class="{
                        show:
                            currentRoute.includes('user-registration/index') ||
                            currentRoute.includes('type-assistance') ||
                            currentRoute.includes('sectors') ||
                            currentRoute.includes('office-charges') ||
                            currentRoute.includes('relationship'),
                    }"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <Link
                            class="nav-link"
                            :href="`/user-registration/index`"
                        >
                            <i
                                class="bi bi-circle"
                                :class="{
                                    'icon-highlight': currentRoute.includes(
                                        'user-registration/index'
                                    ),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight': currentRoute.includes(
                                        'user-registration/index'
                                    ),
                                }"
                                >Users
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link" :href="`/relationship`">
                            <i
                                class="bi bi-circle"
                                :class="{
                                    'icon-highlight':
                                        currentRoute.includes('relationship'),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight':
                                        currentRoute.includes('relationship'),
                                }"
                                >Family Relations
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link" :href="`/office-charges`">
                            <i
                                class="bi bi-circle"
                                :class="{
                                    'icon-highlight':
                                        currentRoute.includes('office-charges'),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight':
                                        currentRoute.includes('office-charges'),
                                }"
                                >Office Charges
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link" :href="`/sectors`">
                            <i
                                class="bi bi-circle"
                                :class="{
                                    'icon-highlight':
                                        currentRoute.includes('sectors'),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight':
                                        currentRoute.includes('sectors'),
                                }"
                                >Sector
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link" :href="`/type-assistance`">
                            <i
                                class="bi bi-circle"
                                :class="{
                                    'icon-highlight':
                                        currentRoute.includes(
                                            'type-assistance'
                                        ),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight':
                                        currentRoute.includes(
                                            'type-assistance'
                                        ),
                                }"
                                >Types of Assistance
                            </span>
                        </Link>
                    </li>
                </ul>
            </div>
            <!-- END OF MAINTENANCE MODULE -->

            <!-- REPORT MODULE -->
            <div v-if="hasAccess(['admin', 'supervisor'])">
                <li class="nav-heading">REPORTS</li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :href="`/summary-report`"
                        :class="{
                            'bg-highlight':
                                currentRoute.includes('summary-report'),
                        }"
                    >
                        <i
                            class="bi bi-newspaper"
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('summary-report'),
                            }"
                        ></i>
                        <span
                            :class="{
                                'color-highlight':
                                    currentRoute.includes('summary-report'),
                            }"
                            >SUMMARY REPORT</span
                        >
                    </Link>
                </li>
                <a
                    class="nav-link collapsed"
                    :class="{
                        'bg-highlight':
                            currentRoute.includes('aics-coe-served') ||
                            currentRoute.includes('aics-per-municipal') ||
                            currentRoute.includes('aics-served-per-sectoral') ||
                            currentRoute.includes('aics-per-sectoral-group'),
                    }"
                    data-bs-target="#components-nav-3"
                    data-bs-toggle="collapse"
                >
                    <i
                        class="bi bi-bar-chart-line"
                        :class="{
                            'text-primary':
                                currentRoute.includes('aics-coe-served') ||
                                currentRoute.includes('aics-per-municipal') ||
                                currentRoute.includes(
                                    'aics-served-per-sectoral'
                                ) ||
                                currentRoute.includes(
                                    'aics-per-sectoral-group'
                                ),
                        }"
                    ></i
                    ><span
                        :class="{
                            'color-highlight':
                                currentRoute.includes('aics-coe-served') ||
                                currentRoute.includes('aics-per-municipal') ||
                                currentRoute.includes(
                                    'aics-served-per-sectoral'
                                ) ||
                                currentRoute.includes(
                                    'aics-per-sectoral-group'
                                ),
                        }"
                        >CHART REPORT</span
                    >
                    <i
                        class="bi bi-chevron-down ms-auto"
                        :class="{
                            'text-primary':
                                currentRoute.includes('aics-coe-served') ||
                                currentRoute.includes('aics-per-municipal') ||
                                currentRoute.includes(
                                    'aics-served-per-sectoral'
                                ) ||
                                currentRoute.includes(
                                    'aics-per-sectoral-group'
                                ),
                        }"
                    ></i>
                </a>
                <ul
                    id="components-nav-3"
                    class="nav-content collapse"
                    :class="{
                        show:
                            currentRoute.includes('aics-coe-served') ||
                            currentRoute.includes('aics-per-municipal') ||
                            currentRoute.includes('aics-served-per-sectoral') ||
                            currentRoute.includes('aics-per-sectoral-group'),
                    }"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <Link
                            class="nav-link collapsed"
                            :href="`/aics-coe-served`"
                        >
                            <i
                                class="bi bi-card-list"
                                :class="{
                                    'icon-highlight':
                                        currentRoute.includes(
                                            'aics-coe-served'
                                        ),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight':
                                        currentRoute.includes(
                                            'aics-coe-served'
                                        ),
                                }"
                                >Intake Sheets & COE Served</span
                            >
                        </Link>
                    </li>
                    <li>
                        <Link
                            class="nav-link collapsed"
                            :href="`/aics-per-municipal`"
                        >
                            <i
                                class="bi bi-card-list"
                                :class="{
                                    'icon-highlight':
                                        currentRoute.includes(
                                            'aics-per-municipal'
                                        ),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight':
                                        currentRoute.includes(
                                            'aics-per-municipal'
                                        ),
                                }"
                                >AICS Per Municipality</span
                            >
                        </Link>
                    </li>
                    <li>
                        <Link
                            class="nav-link collapsed"
                            :href="`/aics-served-per-sectoral`"
                        >
                            <i
                                class="bi bi-card-list"
                                :class="{
                                    'icon-highlight': currentRoute.includes(
                                        'aics-served-per-sectoral'
                                    ),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight': currentRoute.includes(
                                        'aics-served-per-sectoral'
                                    ),
                                }"
                                >AICS Served Per Sectoral Group</span
                            >
                        </Link>
                    </li>
                    <li>
                        <Link
                            class="nav-link collapsed"
                            :href="`/aics-per-sectoral-group`"
                        >
                            <i
                                class="bi bi-card-list"
                                :class="{
                                    'icon-highlight': currentRoute.includes(
                                        'aics-per-sectoral-group'
                                    ),
                                }"
                            ></i>
                            <span
                                :class="{
                                    'color-highlight': currentRoute.includes(
                                        'aics-per-sectoral-group'
                                    ),
                                }"
                                >AICS Per Sectoral Group</span
                            >
                        </Link>
                    </li>
                </ul>
            </div>
        </ul>
        <!-- END OF REPORT MODULE -->

        <!-- USER ROLE ACCESS -->
        <ul class="sidebar-nav" v-if="hasAccess(['user'])">
            <li class="nav-heading">AICS</li>

            <li class="nav-item">
                <Link
                    class="nav-link"
                    :href="`/intake`"
                    :class="{
                        'bg-highlight': currentRoute.includes('intake'),
                    }"
                >
                    <i
                        class="bi bi-file-text"
                        :class="{
                            'color-highlight': currentRoute.includes('intake'),
                        }"
                    ></i>
                    <span
                        :class="{
                            'color-highlight': currentRoute.includes('intake'),
                        }"
                        >INTAKE SHEET</span
                    >
                </Link>
            </li>
            <li class="nav-item">
                <Link
                    class="nav-link"
                    :href="`/monitoring`"
                    :class="{
                        'bg-highlight': currentRoute.includes('monitoring'),
                    }"
                >
                    <i
                        class="bi bi-receipt-cutoff"
                        :class="{
                            'color-highlight':
                                currentRoute.includes('monitoring'),
                        }"
                    ></i>
                    <span
                        :class="{
                            'color-highlight':
                                currentRoute.includes('monitoring'),
                        }"
                        >MONITORING</span
                    >
                </Link>
            </li>
            <li class="nav-item">
                <Link
                    class="nav-link"
                    :href="`/sectoral-data`"
                    :class="{
                        'bg-highlight': currentRoute.includes('sectoral-data'),
                    }"
                >
                    <i
                        class="bi bi-journal"
                        :class="{
                            'color-highlight':
                                currentRoute.includes('sectoral-data'),
                        }"
                    ></i>
                    <span
                        :class="{
                            'color-highlight':
                                currentRoute.includes('sectoral-data'),
                        }"
                        >SECTORAL DATA</span
                    >
                </Link>
            </li>

            <!-- <div v-if="hasAccess(['user'])">
                <li class="nav-heading">OTHERS</li>
                TRANSACTION MODULE
                <li class="nav-item">
                    <Link class="nav-link">
                        <i class="bi bi-file-post-fill"></i>
                        <span>TRANSACTION</span>
                    </Link>
                </li>
                END OF TRANSACTION MODULE
            </div> -->
        </ul>

        <!-- END USER ROLE ACCESS -->
    </aside>
    <!-- End Sidebar-->

    <main class="main" id="main">
        <slot />
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright
            <strong
                ><span>Provincial Government of Surigao Del Sur</span></strong
            >. All Rights Reserved
        </div>
        <!-- <div class="credits">
            Developed by <span class="text-primary"></span>
        </div> -->
    </footer>
    <!-- End Footer -->

    <a
        href="#"
        class="back-to-top d-flex align-items-center justify-content-center"
    >
        <i class="bi bi-arrow-up-short"></i>
    </a>
</template>

<style scoped>
.sidebar-nav .bg-highlight {
    background: #f6f9ff;
}

.sidebar-nav .color-highlight {
    color: #4154f1;
}

.sidebar-nav .icon-highlight {
    background-color: #4154f1;
}
</style>
