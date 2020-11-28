<template>
    <el-dialog width="65%" :title="titleDialog" :visible="showDialog" :close-on-click-modal="false" @close="close" @open="create" append-to-body top="7vh">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                  <div class="col-md-3">
                        <div class="form-group" :class="{'has-danger': errors.laboratorio_id}">
                            <label class="control-label">
                                Laboratorio
                            </label>

                            <a href="#" v-if="form_laboratorio.add == false" class="control-label font-weight-bold text-info" @click="form_laboratorio.add = true"> [ + Nuevo]</a>
                            <a href="#" v-if="form_laboratorio.add == true" class="control-label font-weight-bold text-info" @click="saveLaboratorio()"> [ + Guardar]</a>
                            <a href="#" v-if="form_laboratorio.add == true" class="control-label font-weight-bold text-danger" @click="form_laboratorio.add = false"> [ Cancelar]</a>
                            <el-input   v-if="form_laboratorio.add == true" v-model="form_laboratorio.name" dusk="item_code" style="margin-bottom:1.5%;"></el-input>

                            <el-select v-if="form_laboratorio.add == false" v-model="form.laboratorio_id" filterable clearable>
                                <el-option v-for="option in laboratorios" :key="option.id" :value="option.id" :label="option.name"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.laboratorio_id" v-text="errors.laboratorio_id[0]"></small>
                        </div>
                    </div>

                  <div class="col-md-3">
                        <div class="form-group" :class="{'has-danger': errors.presentacion_id}">
                            <label class="control-label">
                                Presentación
                            </label>

                            <a href="#" v-if="form_presentacion.add == false" class="control-label font-weight-bold text-info" @click="form_presentacion.add = true"> [ + Nuevo]</a>
                            <a href="#" v-if="form_presentacion.add == true" class="control-label font-weight-bold text-info" @click="savePresentacion()"> [ + Guardar]</a>
                            <a href="#" v-if="form_presentacion.add == true" class="control-label font-weight-bold text-danger" @click="form_presentacion.add = false"> [ Cancelar]</a>
                            <el-input   v-if="form_presentacion.add == true" v-model="form_presentacion.name" dusk="item_code" style="margin-bottom:1.5%;"></el-input>

                            <el-select v-if="form_presentacion.add == false" v-model="form.presentacion_id" filterable clearable>
                                <el-option v-for="option in presentaciones" :key="option.id" :value="option.id" :label="option.name"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.presentacion_id" v-text="errors.presentacion_id[0]"></small>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group" :class="{'has-danger': errors.tipprodmed_id}">
                            <label class="control-label">Tipo Prod.</label>
                            <el-select v-model="form.tipprodmed_id" dusk="tipprodmed_id">
                                <el-option v-for="option in tipprodmeds" :key="option.id" :value="option.id" :label="option.description"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.tipprodmed_id" v-text="errors.tipprodmed_id[0]"></small>
                        </div>
                    </div>

                  <div class="col-md-3">
                        <div class="form-group" :class="{'has-danger': errors.clasemed_id}">
                            <label class="control-label">Clase</label>
                            <el-select v-model="form.clasemed_id" dusk="clasemed_id">
                                <el-option v-for="option in clasemeds" :key="option.id" :value="option.id" :label="option.description"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.clasemed_id" v-text="errors.clasemed_id[0]"></small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3" >
                        <div class="form-group" :class="{'has-danger': errors.concentracion}">
                            <label class="control-label">
                               Concentración
                            </label>
                            <el-input v-model="form.concentracion" >
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.concentracion" v-text="errors.concentracion[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="form-group" :class="{'has-danger': errors.via}">
                            <label class="control-label">
                            Vía de Administración
                            </label>
                            <el-input v-model="form.via" >
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.via" v-text="errors.via[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Contraindicaciones</label>
                            <el-input
                                    type="textarea"
                                    autosize
                                    v-model="form.contraindicaciones">
                            </el-input>
                        </div>
                    </div>
                </div>

                <!--achonto-->
                <div v-if="indicaciones.length > 0" class="col-md-12">
                    <h5 class="separator-title ">
                    Indicaciones
                        <a href="#" class="control-label font-weight-bold text-info" @click.prevent="clickAddIndicacion">[+ Agregar]</a>
                    </h5>
                </div>
                <div v-if="form.indications.length > 0" class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Indicación</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in form.indications" :key="index">
                                <td>
                                    <el-select v-model="row.indicacion_id" filterable @change="changeIndicacion(index)">
                                        <el-option v-for="option in indicaciones" :key="option.id" :value="option.id" :label="option.name"></el-option>
                                    </el-select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" @click.prevent="clickRemoveIndicacion(index)">x</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                </div>
            </div>
            <div class="form-actions text-right pt-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
            </div>
        </form>
        <!-- <percentage-perception
                :showDialog.sync="showPercentagePerception"
                :percentage_perception="percentage_perception">
        </percentage-perception> -->

        <lots-form
            :showDialog.sync="showDialogLots"
            :stock="form.stock"
            :recordId="recordId"
            :lots="form.lots"
            @addRowLot="addRowLot">
        </lots-form>

    </el-dialog>
</template>

<script>
    // import PercentagePerception from './partials/percentage_perception.vue'
    import LotsForm from './partials/lots.vue'

    export default {
        props: ['showDialog', 'recordId', 'external'],
        components: {LotsForm},

        data() {
            return {
                showDialogLots:false,
                form_laboratorio:{ add: false, name: null, id: null },//achonto
                form_presentacion:{ add: false, name: null, id: null },//achonto
                form_brand:{ add: false, name: null, id: null },
                warehouses: [],
                loading_submit: false,
                showPercentagePerception: false,
                has_percentage_perception: false,
                percentage_perception:null,
                enabled_percentage_of_profit:false,
                titleDialog: null,
                resource: 'items',
                errors: {},
                headers: headers_token,
                form: {},
                configuration: {},
                unit_types: [],
                currency_types: [],
                system_isc_types: [],
                affectation_igv_types: [],
                tipprodmeds: [],//achonto
                clasemeds: [],//achonto
                laboratorios: [],//achonto
                presentaciones: [],//achonto
                brands: [],
                accounts: [],
                show_has_igv:true,
                purchase_show_has_igv:true,
                have_account:false,
                item_unit_type:{
                        id:null,
                        unit_type_id:null,
                        quantity_unit:0,
                        price1:0,
                        price2:0,
                        price3:0,
                        price_default:2,

                },
                indicaciones:  []//achonto
            }
        },
        async created() {
            await this.initForm()
            await this.$http.get(`/${this.resource}/tablesmed`)
                .then(response => {
                    this.unit_types = response.data.unit_types
                    this.accounts = response.data.accounts
                    this.currency_types = response.data.currency_types
                    this.system_isc_types = response.data.system_isc_types
                    this.affectation_igv_types = response.data.affectation_igv_types
                    this.tipprodmeds = response.data.tipprodmeds//achonto
                    this.clasemeds = response.data.clasemeds//achonto
                    this.indicaciones = response.data.indicaciones//achonto

                    this.warehouses = response.data.warehouses
                    this.laboratorios = response.data.laboratorios//achonto
                    this.presentaciones = response.data.presentaciones//achonto
                    this.brands = response.data.brands
                    this.configuration = response.data.configuration

                    this.form.sale_affectation_igv_type_id = (this.affectation_igv_types.length > 0)?this.affectation_igv_types[0].id:null
                    this.form.purchase_affectation_igv_type_id = (this.affectation_igv_types.length > 0)?this.affectation_igv_types[0].id:null
                })

            this.$eventHub.$on('submitPercentagePerception', (data)=>{
                this.form.percentage_perception = data
                if(!this.form.percentage_perception) this.has_percentage_perception = false
            })

            this.$eventHub.$on('reloadTables', ()=>{
                this.reloadTables()
            })

            await this.setDefaultConfiguration()

        },

        methods: {
            setDefaultConfiguration(){
                this.form.sale_affectation_igv_type_id = (this.configuration) ? this.configuration.affectation_igv_type_id : '10'

                this.$http.get(`/configurations/record`) .then(response => {
                    this.form.has_igv = response.data.data.include_igv
                    this.form.purchase_has_igv = response.data.data.include_igv
                })
            },
            clickAddIndicacion() {
                this.form.indications.push({
                    indicacion_id: null,
                    name: null,
                    start_date: null,
                    end_date: null,
                    duration: null,
                })
            },
            async reloadTables(){

                await this.$http.get(`/${this.resource}/tablesmed`)
                    .then(response => {
                        this.unit_types = response.data.unit_types
                        this.accounts = response.data.accounts
                        this.currency_types = response.data.currency_types
                        this.system_isc_types = response.data.system_isc_types
                        this.affectation_igv_types = response.data.affectation_igv_types
                        this.tipprodmeds = response.data.tipprodmeds//achonto
                        this.clasemeds = response.data.clasemeds//achonto

                        this.warehouses = response.data.warehouses
                        this.laboratorios = response.data.laboratorios//achonto
                        this.presentaciones = response.data.presentaciones//achonto
                        this.brands = response.data.brands

                        this.form.sale_affectation_igv_type_id = (this.affectation_igv_types.length > 0)?this.affectation_igv_types[0].id:null
                        this.form.purchase_affectation_igv_type_id = (this.affectation_igv_types.length > 0)?this.affectation_igv_types[0].id:null
                    })
            },
            changeLotsEnabled(){

                // if(!this.form.lots_enabled){
                //     this.form.lot_code = null
                //     this.form.lots = []
                // }

            },
            addRowLot(lots){
                this.form.lots = lots
            },
            clickLotcode(){
                // if(this.form.stock <= 0)
                //     return this.$message.error('El stock debe ser mayor a 0')

                this.showDialogLots = true
            },
            changeHaveAccount(){
                if(!this.have_account) this.form.account_id = null
            },
            changeEnabledPercentageOfProfit(){
                // if(!this.enabled_percentage_of_profit) this.form.percentage_of_profit = 0
            },
            clickDelete(id) {

                this.$http.delete(`/${this.resource}/item-unit-type/${id}`)
                        .then(res => {
                            if(res.data.success) {
                                this.loadRecord()
                                this.$message.success('Se eliminó correctamente el registro')
                            }
                        })
                        .catch(error => {
                            if (error.response.status === 500) {
                                this.$message.error('Error al intentar eliminar');
                            } else {
                                console.log(error.response.data.message)
                            }
                        })

            },
            changeHasPerception(){
                if(!this.form.has_perception){
                    this.form.percentage_perception = null
                }

            },
            clickAddRow() {
                this.form.item_unit_types.push({
                    id: null,
                    description: null,
                    unit_type_id: 'NIU',
                    quantity_unit: 0,
                    price1: 0,
                    price2: 0,
                    price3: 0,
                    price_default: 2
                })
            },
            clickCancel(index) {
                this.form.item_unit_types.splice(index, 1)
                // this.initDocumentTypes()
                // this.showAddButton = true
            },
            initForm() {
                this.loading_submit = false,
                this.errors = {}
                this.form = {
                    id: null,
                    item_type_id: '01',
                    internal_id: null,
                    item_code: null,
                    item_code_gs1: null,
                    description: null,
                    name: null,
                    second_name: null,
                    unit_type_id: 'NIU',
                    currency_type_id: 'PEN',
                    sale_unit_price: 0,
                    purchase_unit_price: 0,
                    has_isc: false,
                    system_isc_type_id: null,
                    percentage_isc: 0,
                    suggested_price: 0,
                    sale_affectation_igv_type_id: null,
                    purchase_affectation_igv_type_id: null,
                    calculate_quantity: false,
                    stock: 0,
                    stock_min: 1,
                    has_igv: true,
                    has_perception: false,
                    item_unit_types:[],
                    percentage_of_profit: 0,
                    percentage_perception: 0,
                    image: null,
                    image_url: null,
                    temp_path: null,
                    is_set: false,
                    account_id: null,
                    category_id: null,
                    brand_id: null,
                    date_of_due:null,
                    lot_code:null,
                    line:null,
                    lots_enabled:false,
                    lots:[],
                    indications: [],//achonto
                    series_enabled: false,
                    purchase_has_igv: true,
                    web_platform_id:null,
                    laboratorio_id: null,//achonto
                    presentacion_id: null,//achonto
                    tipprodmed_id: '01',//achonto
                    clasemed_id: '01',//achonto
                    concentracion: null,//achonto
                    via: null,//achonto
                    contraindicaciones: null,//achonto
                }
                this.show_has_igv = true
                this.purchase_show_has_igv = true
                this.enabled_percentage_of_profit = false
            },
            onSuccess(response, file, fileList) {
                if (response.success) {
                    this.form.image = response.data.filename
                    this.form.image_url = response.data.temp_image
                    this.form.temp_path = response.data.temp_path
                } else {
                    this.$message.error(response.message)
                }
            },
            changeAffectationIgvType(){

                let affectation_igv_type_exonerated = [20,21,30,31,32,33,34,35,36,37]
                let is_exonerated = affectation_igv_type_exonerated.includes((parseInt(this.form.sale_affectation_igv_type_id)));

                if(is_exonerated){
                    this.show_has_igv = false
                    this.form.has_igv = true
                }else{
                    this.show_has_igv = true
                }

            },
            changePurchaseAffectationIgvType(){

                let affectation_igv_type_exonerated = [20,21,30,31,32,33,34,35,36,37]
                let is_exonerated = affectation_igv_type_exonerated.includes((parseInt(this.form.purchase_affectation_igv_type_id)));

                if(is_exonerated){
                    this.purchase_show_has_igv = false
                    this.form.purchase_has_igv = true
                }else{
                    this.purchase_show_has_igv = true
                }

            },
            resetForm() {
                this.initForm()
                this.form.sale_affectation_igv_type_id = (this.affectation_igv_types.length > 0)?this.affectation_igv_types[0].id:null
                this.form.purchase_affectation_igv_type_id = (this.affectation_igv_types.length > 0)?this.affectation_igv_types[0].id:null
                this.setDefaultConfiguration()
            },
            create() {



                this.titleDialog = (this.recordId)? 'Gestionar Medicamento':'Nuevo Medicamento'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                            this.has_percentage_perception = (this.form.percentage_perception) ? true : false
                            this.changeAffectationIgvType()
                            this.changePurchaseAffectationIgvType()
                        })
                }

            },
            loadRecord(){
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                            this.changeAffectationIgvType()
                            this.changePurchaseAffectationIgvType()
                        })
                }
            },
            calculatePercentageOfProfitBySale() {
                let difference = parseFloat(this.form.sale_unit_price) - parseFloat(this.form.purchase_unit_price);

                if(parseFloat(this.form.purchase_unit_price) === 0) {
                    this.form.percentage_of_profit = 0;
                } else {
                    if(this.enabled_percentage_of_profit) this.form.percentage_of_profit = difference / parseFloat(this.form.purchase_unit_price) * 100;
                }
            },
            calculatePercentageOfProfitByPurchase() {
                if(this.form.percentage_of_profit === '') {
                    this.form.percentage_of_profit = 0;
                }

                if(this.enabled_percentage_of_profit) this.form.sale_unit_price = (this.form.purchase_unit_price * (100 + parseFloat(this.form.percentage_of_profit))) / 100
            },
            calculatePercentageOfProfitByPercentage() {
                if(this.form.percentage_of_profit === '') {
                    this.form.percentage_of_profit = 0;
                }

                if(this.enabled_percentage_of_profit) this.form.sale_unit_price = (this.form.purchase_unit_price * (100 + parseFloat(this.form.percentage_of_profit))) / 100
            },
            validateItemUnitTypes(){

                let error_by_item = 0

                if(this.form.item_unit_types.length > 0){
                    
                    this.form.item_unit_types.forEach(item => {

                        if(parseFloat(item.quantity_unit) < 0.0001){
                            error_by_item++
                        }

                    })

                }

                return error_by_item

            },
            async submit() {

                if(this.validateItemUnitTypes() > 0) return this.$message.error('El campo factor no puede ser menor a 0.0001');

                if(this.form.has_perception && !this.form.percentage_perception) return this.$message.error('Ingrese un porcentaje');
                // if(!this.has_percentage_perception) this.form.percentage_perception = null

                /*if(!this.recordId && this.form.lots_enabled){

                    if(this.form.lots.length > this.form.stock)
                        return this.$message.error('La cantidad de series registradas es superior al stock');

                    if(!this.form.lot_code)
                        return this.$message.error('Código de lote es requerido');

                    if(this.form.lots.length != this.form.stock)
                        return this.$message.error('La cantidad de series registradas son diferentes al stock');

                }*/

                if(!this.recordId && this.form.lots_enabled){

                    if(!this.form.lot_code)
                        return this.$message.error('Código de lote es requerido');

                    if(!this.form.date_of_due)
                        return this.$message.error('Fecha de vencimiento es requerido si lotes esta habilitado.');
                }

                if(!this.recordId && this.form.series_enabled)
                {

                    if(this.form.lots.length > this.form.stock)
                        return this.$message.error('La cantidad de series registradas es superior al stock');

                    if(this.form.lots.length != this.form.stock)
                        return this.$message.error('La cantidad de series registradas son diferentes al stock');
                }

                this.loading_submit = true
                await this.$http.post(`/${this.resource}`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            if (this.external) {
                                this.$eventHub.$emit('reloadDataItems', response.data.id)
                            } else {
                                this.$eventHub.$emit('reloadData')
                            }
                            this.close()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            close() {
                this.$emit('update:showDialog', false)
                this.resetForm()
            },
            changeHasIsc() {
                this.form.system_isc_type_id = null
                this.form.percentage_isc = 0
                this.form.suggested_price = 0
            },
            changeSystemIscType() {
                if (this.form.system_isc_type_id !== '03') {
                    this.form.suggested_price = 0
                }
            },
            saveLaboratorio()//achonto
            {
                this.form_laboratorio.add = false

                this.$http.post(`laboratorios`,  this.form_laboratorio)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        this.laboratorios.push(response.data.data)
                        this.form_laboratorio.name = null
                    } else {
                        this.$message.error('No se guardaron los cambios')
                    }
                })
                .catch(error => {

                })
            },
            savePresentacion()
            {
                this.form_presentacion.add = false

                this.$http.post(`presentaciones`,  this.form_presentacion)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        this.presentaciones.push(response.data.data)
                        this.form_presentacion.name = null
                    } else {
                        this.$message.error('No se guardaron los cambios')
                    }
                })
                .catch(error => {

                })
            },
            saveBrand()
            {
                this.form_brand.add = false

                this.$http.post(`brands`,  this.form_brand)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        this.brands.push(response.data.data)
                        this.form_brand.name = null

                    } else {
                        this.$message.error('No se guardaron los cambios')
                    }
                })
                .catch(error => {

                })



            },
            changeIndicacion(index) {
                let indicacion_id = this.form.indications[index].indicacion_id
                let indicacion = _.find(this.indicaciones, {id: indicacion_id})
                this.form.indications[index].description = indicacion.description
            },
            clickRemoveIndicacion(index) {
                this.form.indications.splice(index, 1)
            },
        }
    }
</script>
