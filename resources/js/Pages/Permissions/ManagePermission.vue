<template>
    <AppLayout title="Dashboard">
        <section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">All Permissions</h5>
                        </div>
                        <div class="col-md-6 text-ri text-right">
                            <button
                                :data-target="'#' + modal_name"
                                v-if="userWiseRolePermission.includes('permission.create')"
                                data-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap"
                                @click.prevent="beforeOpen"
                            >
                                Add New Permission
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    class="card-body table-responsive"
                    style="margin-top: -60px"
                >
                    <!-- <overlay-preloader :action="preload"></overlay-preloader> -->
                    <list-preloader :action="preload"></list-preloader>
                    <div class="px-2 py-1 mt-0">
                        <v-table-head
                            :meta="meta"
                            @changed="pageChange"
                            @search="applySearch"
                        ></v-table-head>
                    </div>

                    <div
                        class="dt-row-grouping table table-bordered"
                        :class="preload ? 'loader-secondary' : ''"
                    >
                        <v-simple-table
                            :headers="[
                                '#SL.',
                                'Group Name',
                                'Permission Name',
                                'Actions',
                            ]"
                        >
                            <tr v-for="(permission, key) in permissionList" :key="key">
                                <td>
                                    {{
                                        meta.per_page *
                                            (meta.current_page - 1) +
                                        (key + 1)
                                    }}
                                </td>
                                <td>
                                    <span> {{ permission.group_name }} </span>
                                </td>

                                <td>
                                    <span> {{ permission.name }} </span>
                                </td>

                                <td class="align-middle">
                                    <button
                                        type="button"
                                        v-if="userWiseRolePermission.includes('permission.edit')"
                                        class="btn btn-primary btn-sm mr-2"
                                        @click.prevent="
                                            onClickHandleAction('edit', permission)
                                        "
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        </v-simple-table>
                        <not-found
                            class="py-5"
                            v-if="permissionList.length == 0"
                            :message="
                                loading
                                    ? 'Loading...'
                                    : 'Oops..! No data available in the system.'
                            "
                        ></not-found>
                    </div>

                    <div class="p-2 mt-3">
                        <v-paginate
                            v-if="permissionList.length > 0"
                            :offset="5"
                            :meta="meta"
                            @changed="pageChange"
                        ></v-paginate>
                    </div>
                </div>
            </div>

           <!--Role Modal start-->
           <div
                class="modal fade"
                :id="modal_name"
                tabindex="-1"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">
                                {{ modal_title }} Permission
                            </h3>
                            <button
                                type="button"
                                class="close rounded-pill"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Add role form -->
                            <form class="form">
                                <div class="form-body">
                                    <div class="row">

                                        <div class="col-12">
                                            <p class="h6 text-warning">** All permission Group name must start with small letter. Like as role</p>

                                        <p class="h6 text-warning">** All permission name must start with "groupname.create", "groupname.read", "groupname.edit", or "groupname.delete"</p>

                                        <p class="h6 text-warning">** Like as "role.create", "role.read", "role.edit", or "role.delete"</p>

                                        <hr>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Group Name</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Group Name"
                                                    v-model="form.group_name"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Permission Name</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Permission Name"
                                                    v-model="form.name"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--/ Add role form -->
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-light-secondary"
                                data-dismiss="modal"
                            >
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary ml-1"
                                data-dismiss="modal"
                                :class="isLoading(loading)"
                                :disabled="loading"
                                @click.prevent="onSubmitForm"
                            >
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">
                                    {{ button_name }}</span
                                >
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Role Modal End-->
        </section>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Permissions } from "../../core/endpoints";
export default {
    components: {
        AppLayout,
    },
    props: {
        all_permissions: {
            type: Object,
            default: {},
        },

    },

    data() {
        return {
            modal_name: "permission-modal",
            modal_title: "",
            button_name: "",
            fetchable: "fetchPermissions",
            filterable: "filters",
            permissionList: [],
            preload: false,
            meta: {},
            loading: false,
            id: null,
            form: this.initForm(),
            userWiseRolePermission:[]
        };
    },

    mounted() {
        this.fetchPermissions();
        //console.log(this.all_permissions);
        this.$store.dispatch('getRoleWisePermissionList')
        .then((response)=>{
            // console.log(response.roleWisePermissionList);
            var all_permissions = response.roleWisePermissionList;
            all_permissions.forEach((item,index)=>{
                this.userWiseRolePermission.push(item.name);
            })
            // console.log(this.userWiseRolePermission)
        });
    },

    watch: {

    },

    computed: {
        getRoleWisePermissionList(){
            return this.$store.getters.roleWisePermissionList;
        },
    },

    methods: {
        beforeOpen() {
            this.modal_title = "Add";
            this.button_name = "Save";
            this.form = this.initForm();
        },

        async onSubmitForm() {
            //return console.log(this.form.name);
            try {
                this.loading = true;
                this.preload = true;
                let formId = parseInt(this.id);
                // return console.log(this.form);

                let { data } = await axios[!this.id ? "post" : "put"](
                    !this.id ? `${Permissions}` : `${Permissions}/${formId}`,
                    this.form
                );
                //return console.log(data)
                this.updateState(data.data, "permissionList", this.id);
                $("#" + this.modal_name).modal("hide");
                toastr.success(
                    `${this.id ? data.message : data.message}`,
                    "Great!"
                );
                this.loading = false;
                this.preload = false;
            } catch (error) {
                //return console.log(error);
                $("#" + this.modal_name).modal("hide");
                this.setFormErrors(error);
                toastr.error("Failed to create Permission!", "Opps!");
                this.loading = false;
                this.preload = false;
            }
        },

        async fetchPermissions() {
            this.preload = true;
            let { data } = await axios.get(
                `permission/lists${this.getURLQueryString()}`
            );
            //console.log(data.data)
            this.permissionList = data.data;
            this.meta = data.meta;
            this.preload = false;
        },
        initForm() {
            return {
                name: null,
                group_name: null,
            };
        },
    },
};
</script>

<style scoped>
label {
    text-transform: capitalize !important;
    font-size: 14px !important;
}
.checkbox label {
    font-size: 13px !important;
}
</style>
