<script setup>
import { defineComponent, onMounted, ref } from "vue";
import Dashboard from "../Pages/Dashboard.vue";
import { Link, usePage } from "@inertiajs/vue3";
import axios from "axios";

function greet(event) {
    alert(`Hello ${name.value}!`);
    // `event` is the native DOM event
    if (event) {
        alert(event.target.tagName);
    }
}

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
});

defineComponent({
    Dashboard,
    Link,
});
</script>

<template>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <Link href="" class="logo d-flex align-items-center">
                <div class="mt-4">
                    <img
                        src="/public/assets/img/pdms-logo.png"
                        style="max-height: 110px"
                    />
                </div>
            </Link>
            <i @click="greet" class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <div class="search-bar">
            <form
                class="search-form d-flex align-items-center"
                method="POST"
                action="#"
            >
                <input
                    type="text"
                    name="query"
                    placeholder="Search"
                    title="Enter search keyword"
                />
                <button type="submit" title="Search">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>

                <li class="nav-item dropdown pe-3">
                    <a
                        class="nav-link nav-profile d-flex align-items-center pe-0"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{
                            page.props.role_type
                        }}</span>
                    </a>

                    <ul
                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                    >
                        <li class="dropdown-header">
                            <i class="bi bi-person-bounding-box"></i>
                            <h6 class="text-uppercase">
                                {{ page.props.fullname }}
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
        <ul class="sidebar-nav" id="sidebar-nav">
            <!-- Admin Dashboard -->
            <li class="nav-item" v-if="hasAccess(['admin'])">
                <Link class="nav-link" :href="`/dashboard`">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD</span>
                </Link>
            </li>

            <!-- User Dashboard -->
            <li class="nav-item" v-if="hasAccess(['user'])">
                <Link class="nav-link" :href="`/user/dashboard`">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD</span>
                </Link>
            </li>

            <!-- Liaison Dashboard -->
            <li class="nav-item" v-if="hasAccess(['liaison'])">
                <Link class="nav-link" :href="`/liaison/dashboard`">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD</span>
                </Link>
            </li>

            <!-- Municipality Dashboard -->
            <li class="nav-item" v-if="hasAccess(['municipal'])">
                <Link class="nav-link" :href="`/municipal/dashboard`">
                    <i class="bi bi-grid"></i>
                    <span>DASHBOARD</span>
                </Link>
            </li>
            <!-- End Dashboard Nav -->

            <!-- AICS MODULE -->
            <!-- ADMIN ROLE ACCESS -->
            <div v-if="hasAccess(['admin'])">
                <li class="nav-heading">Modules</li>

                <a
                    class="nav-link collapsed"
                    data-bs-target="#components-nav-1"
                    data-bs-toggle="collapse"
                >
                    <i class="bi bi-menu-down"></i>
                    <span>AICS</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul
                    id="components-nav-1"
                    class="nav-content collapse"
                    :class="{
                        show:
                            currentRoute.includes('intake') ||
                            currentRoute.includes('monitoring') ||
                            currentRoute.includes('sectoral-data'),
                    }"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <Link :href="`/intake`">
                            <i class="bi bi-journal-text"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('intake'),
                                }"
                                >Intake Sheet</span
                            >
                        </Link>
                    </li>
                    <li>
                        <Link :href="`/monitoring`">
                            <i class="bi bi-journal-text"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('monitoring'),
                                }"
                                >Monitoring</span
                            >
                        </Link>
                    </li>
                    <li>
                        <Link :href="`/sectoral-data`">
                            <i class="bi bi-journal-text"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('sectoral-data'),
                                }"
                                >Sectoral Data</span
                            >
                        </Link>
                    </li>
                </ul>
            </div>
            <!-- END ADMIN ROLE -->

            <!-- USER ROLE ACCESS -->
            <div v-if="hasAccess(['user'])">
                <li class="nav-heading">AICS</li>

                <li class="nav-item">
                    <Link class="nav-link" :href="`/intake`">
                        <i class="bi bi-file-text"></i>
                        <span
                            :class="{
                                'text-primary': currentRoute.includes('intake'),
                            }"
                            >INTAKE SHEET</span
                        >
                    </Link>
                </li>
                <li>
                    <Link class="nav-link" :href="`/monitoring`">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('monitoring'),
                            }"
                            >MONITORING</span
                        >
                    </Link>
                </li>
                <li>
                    <Link class="nav-link" :href="`/sectoral-data`">
                        <i class="bi bi-journal"></i>
                        <span
                            :class="{
                                'text-primary':
                                    currentRoute.includes('sectoral-data'),
                            }"
                            >SECTORAL DATA</span
                        >
                    </Link>
                </li>
            </div>
            <!-- END USER ROLE -->

            <!-- LIAISON ROLE ACCESS -->
            <li class="nav-item" v-if="hasAccess(['liaison'])">
                <Link class="nav-link" :href="`/monitoring`">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span
                        :class="{
                            'text-primary': currentRoute.includes('monitoring'),
                        }"
                        >MONITORING</span
                    >
                </Link>
            </li>
            <!-- END LIAISON ROLE -->

            <!-- MUNICIPAL ROLE ACCESS -->
            <div v-if="hasAccess(['municipal'])">
                <li class="nav-item">
                    <Link class="nav-link" :href="`/sectoral-data`">
                        <i class="bi bi-journal"></i>
                        <span>SECTORAL DATA</span>
                    </Link>
                </li>
            </div>
            <!-- END MUNICIPAL ROLE -->

            <!-- MAINTENANCE MODULE -->
            <div v-if="hasAccess(['admin'])">
                <a
                    class="nav-link collapsed"
                    data-bs-target="#components-nav-2"
                    data-bs-toggle="collapse"
                >
                    <i class="bi bi-gear"></i>
                    <span>MAINTENANCE</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul
                    id="components-nav-2"
                    class="nav-content collapse"
                    :class="{
                        show:
                            currentRoute.includes('user-registration/index') ||
                            currentRoute.includes('type-assistance') ||
                            currentRoute.includes('municipality') ||
                            currentRoute.includes('barangay') ||
                            currentRoute.includes('sectors') ||
                            currentRoute.includes('staff-admin') ||
                            currentRoute.includes('liaison') ||
                            currentRoute.includes('office-charges'),
                    }"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <Link
                            class="nav-link collapsed"
                            :href="`/user-registration/index`"
                        >
                            <i class="bi bi-gear"></i>
                            <span
                                :class="{
                                    'text-primary': currentRoute.includes(
                                        'user-registration/index'
                                    ),
                                }"
                                >Users
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            class="nav-link collapsed"
                            :href="`/type-assistance`"
                        >
                            <i class="bi bi-gear"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes(
                                            'type-assistance'
                                        ),
                                }"
                                >Types of Assistance
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            class="nav-link collapsed"
                            :href="`/municipality`"
                        >
                            <i class="bi bi-gear"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('municipality'),
                                }"
                                >Municipality
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link collapsed" :href="`/barangay`">
                            <i class="bi bi-gear"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('barangay'),
                                }"
                                >Barangay
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link collapsed" :href="`/sectors`">
                            <i class="bi bi-gear"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('sectors'),
                                }"
                                >Sector
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link collapsed" :href="`/staff-admin`">
                            <i class="bi bi-gear"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('staff-admin'),
                                }"
                                >Staff Administered
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link collapsed" :href="`/liaison`">
                            <i class="bi bi-gear"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('liaison'),
                                }"
                                >Liaison
                            </span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            class="nav-link collapsed"
                            :href="`/office-charges`"
                        >
                            <i class="bi bi-gear"></i>
                            <span
                                :class="{
                                    'text-primary':
                                        currentRoute.includes('office-charges'),
                                }"
                                >Office Charges
                            </span>
                        </Link>
                    </li>
                </ul>
            </div>

            <!-- REPORT MODULE -->
            <div v-if="hasAccess(['admin'])">
                <a
                    class="nav-link collapsed"
                    data-bs-target="#components-nav-3"
                    data-bs-toggle="collapse"
                >
                    <i class="bi bi-card-list"></i><span>REPORTS</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul
                    id="components-nav-3"
                    class="nav-content collapse"
                    data-bs-parent="#sidebar-nav"
                >
                    <li>
                        <Link class="nav-link collapsed" href="#">
                            <i class="bi bi-card-list"></i>
                            <span>Intake Sheets & COE Served</span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link collapsed" href="#">
                            <i class="bi bi-card-list"></i>
                            <span>AICS Per Municipality</span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link collapsed" href="#">
                            <i class="bi bi-card-list"></i>
                            <span>AICS Served Per Sectoral Group</span>
                        </Link>
                    </li>
                    <li>
                        <Link class="nav-link collapsed" href="#">
                            <i class="bi bi-card-list"></i>
                            <span>AICS Per Sectoral Group</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </ul>
    </aside>
    <!-- End Sidebar-->

    <main class="main" id="main">
        <slot />
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright
            <strong><span>Province of Surigao Del Sur</span></strong
            >. All Rights Reserved
        </div>
        <div class="credits">Developed by <a href="">PADMO-ITU</a></div>
    </footer>
    <!-- End Footer -->

    <a
        href="#"
        class="back-to-top d-flex align-items-center justify-content-center"
    >
        <i class="bi bi-arrow-up-short"></i>
    </a>
</template>
