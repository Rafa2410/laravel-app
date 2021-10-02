<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="#" class="form newtopic" @submit.prevent="checkForm">
                    <input hidden name="_token" :value="csrfToken">
                    <div class="form-group">
                        <div class="row">
                            <label for="company">{{ __('Select Company') }}:</label>
                            <select class='form-control col-lg-11' v-model='company' @change='getPlants()' id="company">
                                <option value='0'>{{ __('Select Company') }}</option>
                                <option v-for='data in companies' :value='data.id' :key="data.id">{{ data.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="plant">{{ __('Select Plant') }}:</label>
                            <select class='form-control col-lg-11' v-model='plant' @change='getCostCenter()' id="plant">
                                <option value='0'>{{ __('Select Plant') }}</option>
                                <option v-for='data in plants' :value='data.id' :key="data.id">{{ data.name }}</option>
                            </select>
                            <div :class="loadingPlants ? 'col-lg-1 text-center' : 'd-none'">
                                <div class="spinner-border mt-2" style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="costCenter">{{ __('Select Cost Center') }}:</label>
                            <select class='form-control col-lg-11' v-model='costCenter' id="costCenter">
                                <option value='0'>{{ __('Select Cost Center') }}</option>
                                <option v-for='data in costCenters' :value='data.id' :key="data.id">{{ data.name }}</option>
                            </select>
                            <div :class="loadingCostCenter ? 'col-lg-1 text-center' : 'd-none'">
                                <div class="spinner-border mt-2" style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="requestor">{{ __('Requestor') }}</label>
                            <input type="text" id="requestor" class="form-control col-lg-11" :value="requestor">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="costCenter">{{ __('Approvers') }}:</label>
                            <ul class="list-group col-lg-11" style="padding-right: 0;">
                                <li v-for='data in approvers' class="list-group-item" :key="data.id">{{ data.name }}</li>
                            </ul>
                            <div :class="loadingApprovers ? 'col-lg-1 text-center' : 'd-none'">
                                <div class="spinner-border mt-2" style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="status">{{ __('Select Status') }}:</label>
                            <select class='form-control col-lg-11' v-model='status' id="status">
                                <option value='0'>{{ __('Select Status') }}</option>
                                <option v-for='data in statuses' :value='data.id' :key="data.id">{{ __(data.name) }}</option>
                            </select>
                            <div :class="loadingStatus ? 'col-lg-1 text-center' : 'd-none'">
                                <div class="spinner-border mt-2" style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-secondary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                company: null,
                plant: null,
                companies: [],
                plants: [],
                costCenter: null,
                costCenters: [],
                loadingPlants: false,
                loadingCostCenter: false,
                loadingApprovers: false,
                approvers: [],
                statuses: [],
                status: null,
                loadingStatus: false
            }
        },
        methods: {
            getCompanies() {
                axios.get('/list/companies')
                    .then((response) => {
                        this.companies = response.data;
                    })
            },
            getPlants() {
                this.loadingPlants = true;
                axios.get(`/list/plants/${this.company}`)
                    .then((response) => {
                        this.loadingPlants = false;
                        this.plants = response.data;
                    });
                this.getApprovers();
            },
            getApprovers() {
                this.loadingApprovers = true;
                axios.get(`/list/approvers/${this.company}`)
                    .then((response) => {
                        this.loadingApprovers = false;
                        this.approvers = response.data;
                    });
            },
            getCostCenter() {
                this.loadingCostCenter = true;
                axios.get(`/list/costcenter/${this.plant}`)
                    .then((response) => {
                        this.loadingCostCenter = false;
                        this.costCenters = response.data;
                    });
            },
            getStatuses() {
                this.loadingStatus = true;
                axios.get('/list/status')
                    .then((response) => {
                        this.loadingStatus = false;
                        this.statuses = response.data;
                    });
            },
            checkForm(e) {
                console.log('Submitted');
                e.preventDefault();
            }
        },
        props: {
            csrfToken: {
                type: String,
                required: true,
            },
            requestor: {
                type: String,
                required: true
            }
        },
        created() {
            this.getCompanies();
            this.getStatuses();
        }
    }
</script>
