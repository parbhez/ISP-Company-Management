<template>
    <NavBar/>
    <SideBar />
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <!-- Page Heading -->
                <header v-if="$slots.header">
                    <slot name="header" />
                </header>
            </div>

            <div class="content-body">
                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <Footer/>

</template>

<script>
import SideBar from "@/Layouts/SideBar.vue";
import NavBar from "@/Layouts/NavBar.vue";
import Footer from "@/Layouts/Footer.vue";

export default {
    components: {
        NavBar,
        SideBar,
        Footer
    },

    props: {
        title: String,
    },
};
</script>
