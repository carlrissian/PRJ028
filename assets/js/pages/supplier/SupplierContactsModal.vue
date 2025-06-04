<template>
    <erp-modal
        :title="showAndHidden ? (edit ? translations.titles.editContact : translations.titles.addContact) : translations.titles.contactList"
        modal-id="supplier-contacts-modal" size="xl">
        <template slot="body">
            <div class="kt-align-right mb-4">
                <!-- TODO quitar disabled para usar función -->
                <button @click="changeStatus" type="button" class="btn btn-dark kt-label-bg-color-4 ml-3" disabled
                    v-text="showAndHidden ? translations.form.close : translations.form.add">
                </button>
            </div>
            <transition name="fade">
                <div class="form-group row" style="margin-bottom: 0em" v-if="showAndHidden">
                    <input type="hidden" name="code" :value="code">

                    <erp-input-modal class-number="3" :label="translations.fields.departament"
                        @changeUpdateInput="department = $event" :value="department" />

                    <erp-input-modal class-number="3" :label="translations.fields.name" @changeUpdateInput="name = $event"
                        :value="name" />

                    <erp-input-modal class-number="3" :label="translations.fields.email" @changeUpdateInput="mail = $event"
                        :value="mail" />

                    <erp-input-modal class-number="3" :label="translations.fields.phone" @changeUpdateInput="phone = $event"
                        :value="phone" />

                    <erp-textarea-static-filter class-number="12" rows="5" :label="translations.fields.comment"
                        @changeUpdateTextArea="comment = $event.target.value" :value="comment" />
                </div>
            </transition>

            <transition name="fade">
                <div class="kt-align-right mb-4" v-show="showAndHidden">
                    <button v-if="!edit" @click.prevent="insertUpdateProvider('supplier.contact.store', false)"
                        class="btn btn-dark kt-label-bg-color-4" v-text="translations.form.add"></button>
                    <button v-else @click.prevent="insertUpdateProvider('supplier.contact.update', true)"
                        class="btn btn-dark kt-label-bg-color-4" v-text="translations.form.edit"></button>
                </div>
            </transition>

            <bootstrap-table :columns="columns" :data="data" :options="options" ref="table" />
        </template>
    </erp-modal>
</template>

<script>
import Axios from "axios";
import Loading from "../../../assets/js/utilities";
import ErpModal from "../../components/modal/ErpModal";
import ErpInputModal from "../../components/modal/form/ErpInputModal";
import ErpTextareaStaticFilter from "../../components/filterStatic/form/ErpTextareaStaticFilter";

export default {
    name: "SupplierContactsModal",
    components: {
        ErpModal,
        ErpInputModal,
        ErpTextareaStaticFilter,
    },
    props: {
        code: "",
    },
    watch: {
        async code() {
            Loading.starLoading();

            await Axios.get(this.routing.generate("supplier.contact", { code: this.code }))
                .then((response) => {
                    this.data = response.data.rows;
                    Loading.endLoading();
                })
                .catch((e) => {
                    console.error(e);
                    Loading.endLoading();
                });
        }
    },
    data() {
        return {
            translations: {},
            showAndHidden: false,
            edit: false,
            columns: [
                {
                    field: 'department',
                    title: txtTrans.fields.departament,
                    sortable: true
                },
                {
                    field: 'name',
                    title: txtTrans.fields.name,
                    sortable: true
                },
                {
                    field: 'email',
                    title: txtTrans.fields.email,
                    sortable: true
                },
                {
                    field: 'phone',
                    title: txtTrans.fields.phone,
                    sortable: true
                },
                {
                    field: 'comment',
                    title: txtTrans.fields.comment,
                    sortable: true
                },
                {
                    title: txtTrans.form.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        'click .edit': (e, value, row, index) => this.clickEdit(e, value, row, index),
                        'click .remove': (e, value, row, index) => this.clickRemove(e, value, row, index),
                    }
                }
            ],
            options: {
                pagination: false,
                locale: 'es-ES'
            },
            data: [],
            index: 0,
            idContact: 0,
            department: "",
            name: "",
            mail: "",
            phone: "",
            comment: "",
        }
    },
    created() {
        this.translations = txtTrans;
    },
    methods: {
        actionsFormatter() {
            // TODO quitar disabled para usar función
            return [
                `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md edit disabled" title="${txtTrans.form.edit}"><i class="flaticon-edit"></i></a>`,
                `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md remove disabled" title="${txtTrans.form.delete}"><i class="flaticon-delete"></i></a>`
            ].join('');
        },
        changeStatus() {
            this.showAndHidden = !this.showAndHidden;
            if (this.edit) this.edit = false;
            this.clear();
        },
        clear() {
            this.department = '';
            this.name = '';
            this.mail = '';
            this.phone = '';
            this.comment = '';
        },
        clickEdit(e, value, row, index) {
            this.edit = true;
            this.showAndHidden = true;
            this.department = row.department;
            this.name = row.name;
            this.mail = row.mail;
            this.phone = row.phone;
            this.comment = row.comment;
            this.idContact = row.id;
            this.index = index;
        },
        // FIXME utilizar SweetAlert para mejor diesño
        async clickRemove(e, value, row, index) {
            if (window.confirm(this.translations.form.questionDelete + ' ' + row.name + '?')) {
                try {
                    Loading.starLoading();
                    let resp = await Axios.post(this.routing.generate('supplier.contact.delete'), { 'id': row.id });
                    Loading.endLoading();
                    if (resp.data.success) {
                        this.$refs.table.remove({ field: 'mail', values: row.mail });
                    }
                } catch (exception) {
                    Loading.endLoading();
                    console.log(exception);
                }
            }
        },
        async insertUpdateProvider(url, edit) {
            let row = {
                'department': this.department,
                'name': this.name,
                'mail': this.mail,
                'phone': this.phone,
                'comment': this.comment,
            };
            if (this.department !== '' && this.mail !== '' && this.name !== '' && this.phone !== '' && this.comment !== '') {
                Loading.starLoading();

                try {
                    let resp = await Axios.post(this.routing.generate(url), {
                        'code': this.code,
                        'department': this.department,
                        'name': this.name,
                        'mail': this.mail,
                        'phone': this.phone,
                        'comment': this.comment,
                        'id': this.idContact
                    });
                    Loading.endLoading();
                    if (resp.data.success) {
                        this.showAndHidden = false;
                        if (edit) {
                            this.$refs.table.updateRow({ index: this.index, row: row });
                        } else {
                            row.id = this.idContact;
                            this.$refs.table.insertRow({ index: 0, row: row });
                        }
                        this.clear();
                    }
                } catch (e) {
                    Loading.endLoading();
                    console.log(e);
                }
            } else {
                // FIXME utilizar SweetAlert para mejor diesño
                alert(this.translations.form.voidFields);
            }
        },
    },
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity .5s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>