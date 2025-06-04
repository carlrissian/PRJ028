<template>
    <erp-filter>
        <erp-date-picker-filter
            @updateDatePicker="changedPicker('startDate', 'endDate', $event)"
            id="startDateId"
            name="startDate"
            :label="translations.startDate"
            :limit-end-day="dates.endDate"
        />
        <erp-date-picker-filter
            @updateDatePicker="changedPicker('startDate', 'endDate', $event)"
            id="endDateId"
            name="endDate"
            :label="translations.endDate"
            :limit-start-day="dates.startDate"
        />
        <erp-select-filter id="locationId" name="locationId" :label="translations.location">
            <option v-for="item in locations"  :value="item.id" v-text="item.name" :key="item.id"></option>
        </erp-select-filter>
        <erp-multiple-select-filter  id="carGroupsId" name="carGroupsId" :label="translations.groups">
            <option v-for="item in carGroups"  :value="item.id" v-text="item.name" :key="item.id"></option>
        </erp-multiple-select-filter>
    </erp-filter>
</template>

<script>
    import ErpFilter from "../../../components/filter/ErpFilter";
    import ErpDatePickerFilter from "../../../components/filter/form/ErpDatePickerFilter";
    import ErpSelectFilter from "../../../components/filter/form/ErpSelectFilter";
    import ErpMultipleSelectFilter from "../../../components/filter/form/ErpMultipleSelectFilter";
    export default {
        name: "SeasonFilter",
        components: {ErpMultipleSelectFilter, ErpSelectFilter, ErpDatePickerFilter, ErpFilter},
        props: {
            locations: Array,
            carGroups: Array
        },
        data() {
            return {
                startDate: moment,
                endDate: moment,
                dates: {
                    endDate: null,
                    startDate: null
                },
                translations: {},
            }
        },
        mounted() {
            this.startDate = moment().startOf('hour');
            this.endDate = moment().startOf('hour').add(32, 'hour');

            this.translations = txtTrans.txtSeason;

        },
        methods: {
            changedPicker(dateFrom, dateTo, e) {
                let {name, value} = e.target;
                if (value) {
                    switch (name) {
                        case dateTo:
                            this.dates[dateTo] = value;
                            break;
                        case dateFrom:
                            this.dates[dateFrom] = value;
                            break;
                    }
                } else {
                    if (name === dateTo) {
                        this.dates[dateTo] = null;
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>