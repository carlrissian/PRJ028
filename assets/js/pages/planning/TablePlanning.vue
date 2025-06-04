<template>
<div class="kt-portlet kt-portlet--bordered">
    <notifications  position="top right" width="20%" />

    <div class="kt-align-right mb-2" v-bind:style="[styleMargin]"  v-if="showTable">
        <button @click="exportCSV" type="button" class="btn btn-dark kt-label-bg-color-4 mb-5" style="margin-bottom: 0px!important;" >{{txt.downloadExcel}}</button>
    </div>
    <div class="kt-portlet__head" @click="showBody = !showBody">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                {{ txt.planning }} <em :class="showBody ? 'fa icon fa-minus' : 'fa icon fa-plus'"></em>
            </h3>
        </div>
    </div>
    <div class="fixed-table-body" v-if="showBody">

        <table class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded" v-if="showTable">
            <thead align="center">
                <tr>
                    <th class="tableHead" colspan="14"></th>
                    <th align="center" v-for="delegation in delegations" v-text="delegation.branchIATA"></th>
                </tr>
                <tr>
                    <th class="tableHead" colspan="13"></th>
                    <th class="tableHead">{{ txt.orPlan }}</th>
                    <th v-for="(orPlanItem, orPlanIndex) in orPlan">

                        <input type="number"
                               @change="distributedTotal(orPlanIndex + 1)"
                               min="0"
                               :value="orPlanItem"
                               v-bind:id="'orPlan'+orPlanIndex"
                               style="border:1px solid black !important;">

                    </th>
                </tr>
                <tr>
                    <th class="tableHead" v-for="item in header" v-text="item" style="border:1px dotted black"></th>
                    <th v-for="(delegation, key) in delegations" ></th>
                </tr>
            </thead>
            <tbody>
                <tr  v-for="(row, rowIndex) in rows" v-bind:id="rowIndex"   style="border:1px dotted black;">
                    <input type="hidden"  v-bind:name="'fleetPlanId'+rowIndex"
                           v-bind:value="row.id"/>
                  <input type="hidden" v-bind:name="'modelCode'+rowIndex" v-bind:value="row.modelCode" />
                    <td>
                        <!--cogemmos el key 0 que es el id-->
                      <input class="form-control" :value="rowIndex" type="checkbox" name="checks[]" v-bind:id="rowIndex" @click="clickCheck">
                    </td>
                    <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               :name="'brand'+rowIndex"
                               v-bind:data-brand="row.brandList.id"
                              v-bind:value="row.brandList.name" />
                    </td>
                  <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               :name="'model'+rowIndex"
                               v-bind:data-model="row.modelList.id"
                              v-bind:value="row.modelList.name" />
                  </td>
                  <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               :name="'purchaseMethod'+rowIndex"
                               v-bind:data-purchasemethod="row.purchaseMethodList.id"
                               v-bind:value="row.purchaseMethodList.name" />
                  </td>
                  <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               :name="'purchaseType'+rowIndex"
                               v-bind:data-purchasetype="row.purchaseTypeList.id"
                               v-bind:name="'purchaseType'+rowIndex"
                               v-bind:value="row.purchaseTypeList.name" />
                  </td>
                  <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               :name="'gearBox'+rowIndex"
                               v-bind:data-gearbox="row.gearBoxList.id"
                               v-bind:value="row.gearBoxList.name" />
                  </td>
                  <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               :name="'motorizationType'+rowIndex"
                               v-bind:data-motorizationtype="row.motorizationTypeList.id"
                               v-bind:value="row.motorizationTypeList.name" />
                  </td>
                  <td>
                        <!-- Existe ACRISS -->
                        <input type="text" style="width: 65px;" v-if="row.acrissList.id"
                               disabled
                               :name="'acriss'+rowIndex"
                               v-bind:data-acriss="row.acrissList.id"
                               v-bind:value="row.acrissList.name" />
                    <!-- No existe Acriss -->
                    <div v-if="!row.acrissList.id">
                      <erp-select-static @changeValue="onChangeAcriss($event, rowIndex)" class-number="12" style="width: 100px;" v-if="(!row.acriss)" :name="'acrissSelect'+rowIndex">
                        <option value="" label="Selecciona un ACRISS"></option>
                        <option v-for="item in acrissList" :id="item.name+item.id" :value="item.id" :label="item.name"></option>
                      </erp-select-static>
                    </div>
                  </td>

                  <td>
                        <!-- Existe carGroup -->
                        <input type="text" style="width: 65px;" v-if="row.carGroupList.id"
                               disabled
                               :name="'carGroup'+rowIndex"
                               v-bind:data-cargroup="row.carGroupList.id"
                               v-bind:value="row.carGroupList.name" />
                        <!-- No Existe carGroup -->
                        <input type="text" style="width: 65px;" v-if="!row.carGroupList.id"
                               disabled
                               name="carGroupName"
                               :id="'carGroupName'+rowIndex" />
                  </td>
                  <td>
                        <!-- Existe carClass -->
                        <input type="text" style="width: 65px;" v-if="row.carClassList.id"
                               disabled
                               :name="'carClass'+rowIndex"
                               v-bind:data-carclass="row.carClassList.id"
                               v-bind:name="'carClass'+rowIndex"
                               v-bind:value="row.carClassList.name" />
                        <!-- No Existe carGroup -->
                        <input type="text" style="width: 65px;" v-if="!row.carClassList.id"
                               disabled
                               :name="'carClass'+rowIndex"
                               :id="'carClass'+rowIndex"
                               v-bind:data-carclass="row.carClassList.id"
                               v-bind:name="'carClass'+rowIndex"
                               v-bind:value="row.carClassList.name" />
                  </td>
                  <td>
                        <!-- Existe commercialGroup -->
                        <input type="text" style="width: 65px;" v-if="row.commercialGroupList.id"
                               disabled
                               :name="'commercialGroup'+rowIndex"
                               v-bind:data-commercialgroup="row.commercialGroupList.id"
                               v-bind:value="row.commercialGroupList.name" />
                        <!-- No Existe commercialGroup -->
                        <input type="text" style="width: 65px;" v-if="row.commercialGroupList.length==0"
                               disabled
                               :id="'commercialGroup'+rowIndex"
                               :name="'commercialGroup'+rowIndex"
                               v-bind:data-commercialgroup="row.commercialGroupList.id"
                               v-bind:value="row.commercialGroupList.name" />
                  </td>
                  <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               :name="'connectedVehicle'+rowIndex"
                               v-bind:data-connectedvehicle="row.connectedVehicleList"
                               v-bind:id="row.connectedVehicleList"
                               :value="row.connectedVehicleList ? 'Sí' : 'No'"  />
                  </td>
                  <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               v-bind:total="row.unitsTotal"
                               :name="'pending'+rowIndex"
                               v-bind:name="'pending'+rowIndex"
                               v-bind:value="row.unitsTotal"  />
                  </td>
                  <td>
                        <input type="text" style="width: 65px;"
                               disabled
                               v-bind:name="'assignPending'+rowIndex"
                               value="12340000000" />
                  </td>
                    <td v-for="delegation in row.delegations">
                       <input type="number" @keypress="onlyNumber" style="width: 65px;"
                               @change="pendingResult($event,rowIndex); distributedTotal(delegation.idBranch)"
                               v-bind:data-branch="delegation.idBranch"
                               v-bind:name="'unitsCol'+delegation.idBranch"
                               v-bind:id="'result'+rowIndex+'key'+delegation.idBranch"
                               :value="delegation.units" />
                    </td>
                </tr>
                <tr>
                    <td colspan="1">
                        <input class="form-control" type="checkbox" :value="1" id="checkboxAll" @click="clickCheckAll">
                    </td>
                    <td colspan="12"></td><td class="tableHead">{{txt.distributedTotal}}</td><td  align='center' v-for="(item, index) in orPlan" v-bind:name="'distributedTotal'+index" v-text='0' style="border:1px dotted black"></td>
                </tr>
                <tr>
                    <td colspan="13"></td>
                    <td class="tableHead">{{txt.distributionPending}}</td>
                    <td  align='center'  v-for="(item, index) in orPlan" v-bind:name="'distributionPending'+index" v-text='0' style="border:1px dotted black"></td>
                </tr>
                <tr v-if="showTable" id="purchaseTypeResults"></tr>
            </tbody>
        </table>

        <div class="kt-align-right mb-4" v-if="showTable">
            <button  @click="saveData(0)"  type="button" id="btnSave" class="btn btn-success mb-5">{{txt.save}}</button>
            <button  @click="saveData(1)" type="button" class="btn btn-success mb-5" id="btnValidate">{{txt.validate}}</button>
            <button  @click="saveData(2)" type="button" class="btn btn-success mb-5">{{txt.reactivate}}</button>
        </div>

            <div class="kt-portlet__head" >
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ txt.abstractCarClass }} <i :class="'fa icon fa-minus'"></i>
                    </h3>
                </div>
            </div>
            <table-planing-carclass v-if="showTable" :branch="delegations"/>
            <table class="table table-bordered" style="width: 100%"  v-if="showTable">
                <thead align="center">
                <tr>
                    <th align="center"  v-text="txt.carClass" class="tableHead"></th> <th align="center" v-for="delegation in delegations" v-text="delegation.branchIATA" class="tableHead"></th>
                </tr>
                </thead>
                <tbody id="summaryCarclass"> </tbody>
            </table>
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ txt.abstractCarClassAccumulated }} <i :class="'fa icon fa-minus'"></i>
                    </h3>
                </div>
            </div>

<!--            <table-planing-carclass-acumulated v-if="showTable" :branch="delegations" />-->

        <table class="table table-bordered" style="width: 100%"  v-if="showTable">
                <thead align="center">
                <tr>
                    <th align="center"  v-text="txt.carClass" class="tableHead"></th>
                    <th align="center" v-for="delegation in delegations" v-text="delegation.branchIATA" class="tableHead"></th>
                </tr>
                </thead>
                <tbody id="summaryCarclassAcumulated"> </tbody>
            </table>

    </div>
</div>
</template>

<script>
    import Loading from "../../../assets/js/utilities";
    import ErpCheckboxStaticFilter from "../../components/filterStatic/form/ErpCheckboxStaticFilter";
    import Axios from "axios";
    import ErpSelectStatic from "../../components/filterStatic/form/ErpSelectStatic";
    import TablePlaningCarclass from "./TablePlaningCarclass";
    import TablePlaningCarclassAcumulated from "./TablePlaningCarclassAcumulated";
    export default {
        name: "TablePlanning",
        components:{
            TablePlaningCarclassAcumulated,
            TablePlaningCarclass,
            ErpSelectStatic,
            ErpCheckboxStaticFilter
        },
        props: {
            dataTable: null,
            month: Number,
            selectList: Object,
            orPlan: null,
           showTable: {
                type: Boolean,
                default: false
            },

        },
        mounted() {
             this.txt = txtTrans.txtForm;
             this.delegations = this.selectList.branchList;
             this.acrissList = this.selectList.acrissList;



        },
        updated(){
            this.checkToReactivate();

        },
        data() {
            return {
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                header: ['Estado','Marca','Modelo', 'Método de Compra','Tipo de Compra','Caja de Cambios', 'Tipo de Motorización','Acriss','Grupo','Carclass','Grupo Comercial','Vehiculo Conectado', 'Total Unidades','Asignaciones Pendientes'],
                delegations: [],
                colorDefault: '#a5baff',
                rows: [],
                showBody: true,
                txt:{},
                checkLine:[],
                styleMargin:{
                    marginTop: '15px',
                    marginRight: '15px',
                    marginBottom: '0!important'
                },
                acrissList: Array,
                acrissSelected: Array,
            }
        },
        watch: {
            dataTable() {
                this.rows = this.dataTable.body;
                this.checkLine = this.dataTable.checkLine;

                console.log(this.rows);
            }
        },
        methods: {
            setValue(value){
                if(typeof value === 'object'){
                    return value.name;
                }
                // ConnectedVehícle
                if(value === true){
                    return 'Sí';
                }else if(value === false){
                    return 'No';
                }

                return value;
            },
            onChangeAcriss(event, lineKey){
                for (let acriss of this.acrissList) {
                    if(acriss.id == event.target.value){
                        document.getElementById('carGroupName'+lineKey).value = acriss.carGroup;
                        document.getElementById('carClass'+lineKey).value = acriss.carClass;
                        document.getElementById('commercialGroup'+lineKey).value = acriss.commercialGroupName;
                        break;
                    }
                }
            },
            clickCheck(){
                // if($('[name="checks[]"]:checked').is(':checked') ) {
                //     document.getElementById('btnSave').disabled = true;
                // }
                // else{
                //     document.getElementById('btnSave').disabled = false;
                // }
            },
            clickCheckAll(){
              if( $('#checkboxAll').is(':checked') ) {
                  $('[name="checks[]"]').prop("checked", true);
              } else {
                  $('[name="checks[]"]').prop("checked", false);
              }
            },
            sendFromParameterFilter(url) {
                let objs = this.$store.getters['filter/items'];
                let keys = Object.keys(objs);
                let form = document.createElement('form');
                form.setAttribute('method', 'POST');
                form.setAttribute('action', url);
                if (keys.length > 0) {
                    for (let key of keys) {
                        let input = document.createElement('input');
                        input.setAttribute('type', 'hidden');
                        input.setAttribute('name', key);
                        input.setAttribute('value', objs[key]);
                        form.appendChild(input);
                    }
                }
                else{//enviamos el mes solamente en el caso de que no busque nada
                    let input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', 'month');
                    input.setAttribute('value', this.month);
                    form.appendChild(input);
                    let inputY = document.createElement('input');
                    inputY.setAttribute('type', 'hidden');
                    inputY.setAttribute('name', 'year');
                    inputY.setAttribute('value', $('#year').val());
                    form.appendChild(inputY);
                }
                document.body.appendChild(form);
                form.submit();
            },
            onlyNumber ($event) {
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57)) {
                    $event.preventDefault();
                }
            },
            pendingResult(event,lineKey){


                let result;
                let inputfindPending = 'pending'+lineKey;
                let pending = document.getElementsByName(inputfindPending)[0];
                let inputfindAssignPending = 'assignPending'+lineKey;
                let assignPending = document.getElementsByName(inputfindAssignPending)[0];
                let total=0;

                if(this.showTable) {
                    if (event!=0 && event.target.value == '') {//si viene vacio que lo ponga a 0
                        $('#' + event.target.id).val(0);
                    }

                    for (let i = 0; i < this.rows.length; i++) {

                        let resume_table = document.getElementById(i);

                        resume_table.querySelectorAll('td').forEach((item, key) => {
                            if (key > 13) {
                                if (lineKey == i) {//sumamos por fila

                                    total += parseInt(item.children[0].value);
                                    result = (pending.value) - total;
                                    assignPending.value = result;
                                }
                            }
                        });
                    }

                    if ( result === 0 ) {
                        $('input[name="' + inputfindAssignPending + '"]').parent().removeClass( 'pendingError' ).addClass( 'pendingValidate' );
                    } else {
                        $('input[name="' + inputfindAssignPending + '"]').parent().removeClass( 'pendingValidate' ).addClass( 'pendingError' );
                    }

                    //si ponemos mas de las unidades que tenemos en asignaciones pendientes, lo deja a 0 la casilla y suma el resto de la fila para que haga los calculos
                    if(event!=0 && result < 0){
                        $('#' + event.target.id).val(0);
                        this.pendingResult(0,lineKey);
                        alert( this.txt.assignedUnits + ' > ' + this.txt.totalUnits );
                    }
                }
            },
            distributedTotal(colum){//recibimos la columna
               let total = 0;
               let totalDistributionPending = 0;
                if(this.showTable) {
                    for (let i = 0; i < this.rows.length; i++) {
                        let resume_table = document.getElementById(i);
                        resume_table.querySelectorAll('td').forEach((item, key) => {

                            if (key > 13) {
                                if (item.children[0].name == 'unitsCol' + colum) {
                                    total += parseInt(item.children[0].value);
                                    let inputfindDistributedTotal = 'distributedTotal' + (colum - 1);
                                    document.getElementsByName(inputfindDistributedTotal)[0].textContent = total;

                                    //Pendiente de distribuir es el total distribuido - el orplan
                                    let inputfindDistributionPending = 'distributionPending' + (colum - 1);
                                    totalDistributionPending = total - ($('#orPlan' + (colum - 1)).val());
                                    document.getElementsByName(inputfindDistributionPending)[0].textContent = totalDistributionPending;
                                }
                            }
                        });

                    }
                    this.purchaseTypeTotal();
                }
            },
            purchaseTypeTotal(){
                let unit = 0;
                let j=0;
                let purchaseTypeArray=[];
                let carClassArray=[];
                let carClassAccumulatedArray=[];

                for(let i=0; i < this.rows.length; i++) {
                    let resume_table = document.getElementById(i);
                    let column=1;


                    resume_table.querySelectorAll('td').forEach((item, key) => {


                        if (key > 13) {

                            if (item.children[0].name == 'unitsCol' + column) {
                                unit = parseInt(item.children[0].value);
                                let inputfindPurchase = 'purchaseType' + i;
                                let purchase = document.getElementsByName(inputfindPurchase)[0];

                                let inputfindCarclass = 'carClass' + i;
                                let carClass = document.getElementsByName(inputfindCarclass)[0];

                                purchaseTypeArray[j] = {
                                    'name': purchase.value,
                                    'unit': unit,
                                    'column': item.children[0].name+''+purchase.value
                                };
                                carClassArray[j] = {
                                    'name': carClass.value,
                                    'unit': unit,
                                    'column': item.children[0].name+''+carClass.value
                                };
                               //obtenemos los porcentajes en base al resumen
                                let inputfindDistributed = 'distributedTotal' + (column-1);
                                let distributed = document.getElementsByName(inputfindDistributed)[0];
                                let quantity = (unit * 100);
                                let percentage = (quantity / distributed.textContent).toFixed(0);

                                carClassAccumulatedArray[j] = {
                                    'name': carClass.value,
                                    'unit':  percentage > 0 ? parseInt(percentage) : 0,
                                    'column': item.children[0].name+''+carClass.value
                                };
                                j++;
                            }
                            column++;
                        }
                    });

                }
                let foundMovements = [];
                let new_ArrayPurchaseType = [];

                purchaseTypeArray.map(function(valor, indice){
                    if(foundMovements.indexOf(valor.column) === -1){

                        foundMovements.push(valor.column);
                        new_ArrayPurchaseType.push(valor);
                    }
                    else{

                        let recovered = foundMovements.indexOf(valor.column);
                        let objectRecovered = new_ArrayPurchaseType[recovered];
                        objectRecovered.unit = objectRecovered.unit + valor.unit;

                    }
                });
                let table = "<td colspan='13'></td>";
                let delegations = this.delegations.length;
                new_ArrayPurchaseType.map(function(valor, index){
                    if( index % delegations === 0){
                        table += '<td class="tableHead">Total <br/>'+valor.name+'</td><td style="border: 1px dotted black;" align="center"> '+valor.unit+'</td> ';
                    }

                    else{ table += '<td align="center" style="border: 1px dotted black;">'+valor.unit+'</td> ';}
                });

                document.getElementById("purchaseTypeResults").innerHTML = table;

                //sumary carclass
                let foundCarclass = [];
                let new_ArrayCarclass = [];


                carClassArray.map(function(valor, indice){
                    if(foundCarclass.indexOf(valor.column) === -1){

                        if(valor.name!==''){
                            foundCarclass.push(valor.column);
                            new_ArrayCarclass.push(valor);
                        }
                    }
                    else{

                        let recoveredCarclass = foundCarclass.indexOf(valor.column);
                        let objectRecoveredCarclass = new_ArrayCarclass[recoveredCarclass];
                        objectRecoveredCarclass.unit = objectRecoveredCarclass.unit + valor.unit;

                    }
                });
                let tableCarclass = "<table border=1 width=100% align='right'>";
                let delegationsCarclass = this.delegations.length;
                new_ArrayCarclass.map(function(valor, index){
                    if( index % delegationsCarclass === 0){
                        tableCarclass +='<tr>';
                        tableCarclass += '<td  >'+valor.name+'</td><td align="center">'+valor.unit+'</td> ';
                    }else{
                        tableCarclass += '<td align="center">'+valor.unit+'</td> ';
                    }
                });
                tableCarclass +='</table>';
                if(this.showTable) {
                    document.getElementById("summaryCarclass").innerHTML = tableCarclass;
                }

                //sumary Acumulado carclass
                let foundAcumulatedCarclass =[];
                let new_ArrayCarclassAcumulated = [];
                carClassAccumulatedArray.map(function(valor, indice){
                    if(foundAcumulatedCarclass.indexOf(valor.column) === -1){

                        if(valor.name !== ''){
                            foundAcumulatedCarclass.push(valor.column);
                            new_ArrayCarclassAcumulated.push(valor);
                        }
                    }else{
                        let recoveredCarclassAcumulated = foundAcumulatedCarclass.indexOf(valor.column);
                        let objectRecoveredCarclassAcumulated = new_ArrayCarclassAcumulated[recoveredCarclassAcumulated];
                        objectRecoveredCarclassAcumulated.unit = objectRecoveredCarclassAcumulated.unit + valor.unit;
                    }
                });
                let tableCarclassAcumulated = "<table border=1 width=100% align='right'>";
                let delegationsCarclassAcumulated = this.delegations.length;
                new_ArrayCarclassAcumulated.map(function(valor, index){
                    if( index % delegationsCarclassAcumulated === 0){
                        tableCarclassAcumulated +='<tr>';
                        tableCarclassAcumulated += '<td> '+valor.name+'</td><td align="center"> '+valor.unit+'%</td> ';
                    }else{
                        tableCarclassAcumulated += '<td align="center">'+valor.unit+' %</td> ';
                    }
                });
                tableCarclassAcumulated +='</table>';
                if(this.showTable) {
                    document.getElementById("summaryCarclassAcumulated").innerHTML = tableCarclassAcumulated;
                }

            },
            exportCSV() {
                let arrayVehiclesId = [];
                let vehicles = [];
                let delegationKeys = Object.keys(this.delegations);
                let orPlan = this.getOrPlan(delegationKeys.length);

                $('[name="checks[]"]').map(function(){
                    arrayVehiclesId.push( this.value );
                }).get();

                vehicles = this.getVehiclesCsv(arrayVehiclesId);

                this.sendFromParameterFilter(this.routing.generate('planning.excel', {
                    'vehicleLinesId': vehicles,
                    'orPlan': orPlan
                }))
            },
            async saveData(validate) {
                let arrayVehiclesId = [];
                let arrayVehiclesNotCheckedId = [];
                let vehicles = [];
                let model = [];

                 $('[name="checks[]"]:checked').map(function(){
                    arrayVehiclesId.push( this.value );
                }).get();

                $('[name="checks[]"]').not(':checked').map(function () {
                    arrayVehiclesNotCheckedId.push( this.value);
                }).get();

                let delegationKeys=Object.keys(this.delegations);

                if(validate==1 || validate==2) { //si es validar o reactivar
                   model = this.getBodyData(arrayVehiclesId,arrayVehiclesNotCheckedId);
                   vehicles =  this.getVehicles(arrayVehiclesId, arrayVehiclesNotCheckedId);
                }
                else{//si es guardar todos mando los no marcados
                    model = this.getBodyData(arrayVehiclesNotCheckedId,null);
                    vehicles = this.getVehicles(arrayVehiclesNotCheckedId,null);
                }

                let orPlan = this.getOrPlan(delegationKeys.length);
                let year = document.getElementById('year').value;
                let month = this.month;

                let text="";
                if(validate === 0){
                     text=this.txt.titleSave;
                }else if(validate === 1){
                     text=this.txt.titleValidate;

                }else{
                    text=this.txt.titleReactivate;
                }
                if(vehicles != 0) {
                    if (confirm(text)) {
                        Loading.starLoading();
                        try {
                            let response = await Axios.post(this.routing.generate('planning.store', {
                                'vehicleLinesId': vehicles,
                                'model': model,
                                'orPlan': orPlan,
                                'validate': validate,
                                'year': year,
                                'month': month,
                                'acrissSelected': this.acrissSelected
                            }));
                            if (response.data.responseStatus) {
                                this.$notify({
                                    title: 'Success',
                                    type: 'success',
                                    text: response.data.message
                                });

                                if(validate==2){
                                    for(var i = 0; i<arrayVehiclesId.length; i++){
                                        this.checkLine[arrayVehiclesId[i]] = false;
                                    }

                                    this.checkToReactivate();

                                }else if(validate == 1){

                                    for(var i = 0; i<arrayVehiclesId.length; i++){
                                        $('tr[id='+arrayVehiclesId[i]+']').addClass('selected').css('pointer-events','none').css('background-color','#cdcdcd');
                                        $('tr td input[id='+arrayVehiclesId[i]+']')[0].css('pointer-events','all').css('background-color','#cdffcd');
                                    }
                                    this.checkToReactivate();
                                }
                            }
                            Loading.endLoading();
                        } catch (e) {
                            console.log(e);
                            Loading.endLoading();
                        }
                        this.purchaseTypeTotal();
                    }
                }
            },
            checkToReactivate(){
                for(let i=0; i < this.checkLine.length; i++){
                    let validate=this.checkLine[i];
                    if(validate){
                        $('tr[id='+i+']').addClass('selected').css('pointer-events','none').css('background-color','#cdcdcd');
                        $('tr td input[id='+i+']').css('pointer-events','all').css('background-color','#cdffcd');
                    }else{
                        $('tr[id='+i+']').removeClass('selected').css('pointer-events','auto').css('background-color','#ffffff');
                        $('tr td input[id='+i+']').css('pointer-events','auto').css('background-color','#ffffff');
                    }
                    this.pendingResult(0,i);
                }
                for(let j=0; j < this.delegations.length; j++){
                    this.distributedTotal(j);
                }
            },
            getOrPlan(numBranch){
                let orPlan = {};
                for(let i = 0; i < numBranch; i++) {
                    orPlan[i]  = $('#orPlan'+i).val();//obtengo los datos orPlan
                }
                return orPlan;
            },
            getVehicles(arrayIds,arrayVehiclesNotCheckedId){
                let keyArray = 0;
                let body = [];
                let linePendingArray = [];

                for (let i = 0; i < arrayIds.length; i++) {


                    let resume_table = document.getElementById(arrayIds[i]);//Obtengo toda la fila con id = al que seleccionas
                    let bodyVehicle = {};
                    let j = 0;
                    let totalUnits = 0;
                    let pendingAssigments = 0;
                    resume_table.querySelectorAll('td').forEach((item, key) => {

                        if (key > 13 && key != 0) {//introducimos los input
                            bodyVehicle[j] = {
                                'idBranch': item.children[0].dataset.branch,
                                'units': parseInt(item.children[0].value)
                            };
                            totalUnits += parseInt(item.children[0].value);
                            j++;
                        }
                        if (key == 13) {
                            pendingAssigments = parseInt(item.children[0].value);
                        }
                    });
                    body[keyArray] = bodyVehicle;
                    keyArray++;

                    if (pendingAssigments > 0) {
                        linePendingArray.push(arrayIds[i]);
                    }
                }

                if ( linePendingArray.length > 0 ) {
                    alert(this.txt.messageAssignPending + ' ' + linePendingArray.toString() );
                }

                if(arrayVehiclesNotCheckedId != null) {
                    for (let k = 0; k < arrayVehiclesNotCheckedId.length; k++) {
                        let j = 0;
                        let bodyVehicleNot = {};
                        for (let m = 14; m < this.rows[arrayVehiclesNotCheckedId[k]].length; m++) {

                            bodyVehicleNot[j] = {
                                'idBranch': this.rows[arrayVehiclesNotCheckedId[k]][m].idBranch,
                                'units': parseInt(this.rows[arrayVehiclesNotCheckedId[k]][m].units)
                            };
                            j++;
                        }
                        body[keyArray] = bodyVehicleNot;
                        keyArray++;
                    }
                }
               return body;
            },
            getVehiclesCsv(arrayIds){
                let keyArray = 0;
                let body = [];

                for (let i = 0; i < arrayIds.length; i++) {
                    let resume_table = document.getElementById(arrayIds[i]);//Obtengo toda la fila con id = al que seleccionas
                    let bodyVehicle = {};
                    let j = 0;
                    let totalUnits = 0;
                    resume_table.querySelectorAll('td').forEach((item, key) => {
                        if (key > 13 && key !== 0) {//introducimos los input
                            bodyVehicle[j] = {
                                'idBranch': item.children[0].dataset.branch,
                                'units': parseInt(item.children[0].value)
                            };
                            totalUnits += parseInt(item.children[0].value);
                            j++;
                        }
                    });
                    body[keyArray] = bodyVehicle;
                    keyArray++;
                }

                return body;
            },
            getBodyData(arrayIds,arrayVehiclesNotCheckedId) {
                const body = [];
                let keyArray = 0;
                this.acrissSelected = [];

                for (let i = 0; i < arrayIds.length; i++) {
                    let resume_table = document.getElementById(arrayIds[i]);//Obtengo toda la fila con id = al que seleccionas
                    let bodyValue = {};

                    resume_table.querySelectorAll('td').forEach((item, key) => {

                        if (key == 0) {//introducimos fleetPlanId
                            let inputFindFleetPlanId = 'fleetPlanId' + parseInt(item.children[0].value);
                            let fleetPlanId = document.getElementsByName(inputFindFleetPlanId)[0];
                            bodyValue['fleetPlanId'] = fleetPlanId.value;

                          let inputModelCodeId = 'modelCode' + parseInt(item.children[0].value);
                          let $modelCodeId = document.getElementsByName(inputModelCodeId)[0];
                            bodyValue['modelCode'] = $modelCodeId.value;
                        }
                        if(key == 7){// Acriss id
                            if(document.getElementsByName('acrissSelect'+i).length>0){
                                var e = document.getElementsByName('acrissSelect'+i)[0];
                                if(e && e.options[e.selectedIndex].value!==''){
                                    this.acrissSelected.push( {
                                        [bodyValue['fleetPlanId']] : e.options[e.selectedIndex].value
                                    });
                                }
                            }
                        }
                    });

                    body[keyArray] = bodyValue;
                    keyArray++;
                }

                //guardamos los no chequeados
                if(arrayVehiclesNotCheckedId != null) {
                    for (let i = 0; i < arrayVehiclesNotCheckedId.length; i++) {
                        let resume_table = document.getElementById(arrayVehiclesNotCheckedId[i]);//Obtengo toda la fila con id = al que seleccionas
                        let bodyValue = {};

                        resume_table.querySelectorAll('td').forEach((item, key) => {
                            if (key == 0) {//introducimos fleetPlanId
                                let inputFindFleetPlanId = 'fleetPlanId' + parseInt(item.children[0].value);
                                let fleetPlanId = document.getElementsByName(inputFindFleetPlanId)[0];

                                bodyValue['fleetPlanId'] = fleetPlanId.value;

                            }
                        });

                        body[keyArray] = bodyValue;
                        keyArray++;

                    }
                }
                return body;
            },
        }
    }
</script>

<style>
    table select{
        position: absolute;
        top: -9px;
        left: 0px;
        margin-top:0px;
    }
    table .tableHead {
        border:1px dotted black;
        background-color: #a5baff !important;
    }
    table .rowField {
        border:1px dotted black;
        font-weight: bold
    }
    table .pendingValidate{
        background-color: #A5FFB2;
    }
    table .pendingError{
        background-color: #FFA6A5;
    }
    table input {
        width: 50%;
        text-align: center;
        border: none !important;
    }
    .kt-portlet__head {
        cursor: pointer;
        margin-bottom: 0 !important;
        padding: 0 40px !important;
    }
    .icon {
        position: absolute;
        left: 18px;
        top: 23px;
    }
    input[type='number'] {
        -moz-appearance:textfield;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
</style>