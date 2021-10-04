<template>
    <div class="container">
        <div id="loading" style="display: none;">
            <img id="loading-image" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="Loading..." />
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="#" method="POST">
                    <!-- Hidden inputs csfr token and request id -->
                    <input hidden name="_token" :value="csrfToken">
                    <input hidden name="id" :value="requestId">
                    <!-- Errors -->
                    <div class="row errors">
                        <p v-if="errors.length">
                            <b>{{ __('Please correct the following error (s): ') }}</b>
                            <ul>
                                <li v-for="error in errors" :key="error">{{ __(error) }}</li>
                            </ul>
                        </p>
                    </div>
                    <!-- Alert -->
                    <div class="alert alert-success d-none" id="edit-alert">
                      <p>{{ __('Request edited successfully') }}</p>
                    </div>
                    <!-- Company -->
                    <div class="form-group">
                        <div class="row">
                            <label for="company" style="width: 100%;">{{ __('Company') }} *</label>
                            <select class='form-control col-lg-11' v-model='company' @change='resetRelations()' name="company" id="company" required>
                                <option value='0'>{{ __('Select Company') }}</option>
                                <option v-for='data in companies' :value='data.id' :key="data.id">{{ data.name }}</option>
                            </select>
                        </div>
                    </div>
                    <!-- Plant -->
                    <div class="form-group">
                        <div class="row">
                            <label for="plant" style="width: 100%;">{{ __('Plant') }} *</label>
                            <select class='form-control col-lg-11' v-model='plant' @change='resetPlantRelations()' name="plant" id="plant" required>
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
                    <!-- Cost center -->
                    <div class="form-group">
                        <div class="row">
                            <label for="costCenter">{{ __('Cost Center') }} *</label>
                            <select class='form-control col-lg-11' v-model='center' name="costCenter" id="costCenter" required>
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
                    <!-- Requestor -->
                    <div class="form-group">
                        <div class="row">
                            <label for="requestor">{{ __('Requestor') }}</label>
                            <input type="text" id="requestor" class="form-control col-lg-11" :value="requestor" readonly>
                        </div>
                    </div>
                    <!-- Approvers -->
                    <div class="form-group">
                        <div class="row">
                            <label for="approvers">{{ __('Approvers') }} </label>
                            <ul class="list-group col-lg-11" id="approvers" style="padding-right: 0;">
                                <li v-for='data in approvers' class="list-group-item" :key="data.id">{{ data.name }}</li>
                            </ul>
                            <div :class="loadingApprovers ? 'col-lg-1 text-center' : 'd-none'">
                                <div class="spinner-border mt-2" style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <!-- Contact -->
                    <div class="form-group">
                        <div class="row">
                            <label for="contacts">{{ __('Contact Name') }} *</label>
                            <select class='form-control col-lg-11' name="contact" v-model='contact' id="contacts" required>
                                <option value='0'>{{ __('Select Contact Name') }}</option>
                                <option v-for='data in contacts' :value='data.id' :key="data.id">{{ data.name }}</option>
                            </select>
                            <div :class="loadingContacts ? 'col-lg-1 text-center' : 'd-none'">
                                <div class="spinner-border mt-2" style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <!-- Reason -->
                    <div class="form-group">
                        <div class="row">
                            <label for="reason" style="width: 100%;">{{ __('Reason') }} *</label>
                            <textarea name="reason" id="reason" cols="30" rows="6" v-model='reason' class="form-control col-lg-11" required></textarea>
                        </div>
                    </div>
                    <!-- Start date -->
                    <div class="form-group">
                        <div class="row">
                            <label for="start_date" style="width: 47%;">{{ __('Start Date') }} *</label>
                            <label for="start_time" style="width: 50%;">{{ __('Start Time') }} *</label>
                            <input type="date" name="start_date" class="form-control" id="start_date" v-model='start_date' style="width: 45%; margin-right: 2%;" required>
                            <input type="time" name="start_time" class="form-control" id="start_time" v-model='start_time' style="width: 45%;" required>
                        </div>
                    </div>
                    <!-- End date -->
                    <div class="form-group">
                        <div class="row">
                            <label for="end_date" style="width: 47%;">{{ __('End Date') }} *</label>
                            <label for="end_time" style="width: 50%;">{{ __('End Time') }} *</label>
                            <input type="date" name="end_date" class="form-control" id="end_date" v-model='end_date' style="width: 45%; margin-right: 2%;" required>
                            <input type="time" name="end_time" class="form-control" id="end_time" v-model='end_time' style="width: 45%;" required>
                        </div>
                    </div>
                    <!-- Room -->
                    <div class="form-group">
                        <div class="row">
                            <label for="rooms" style="width: 100%;">{{ __('Room') }} *</label>
                            <select class='form-control col-lg-11' name="room" v-model='room' id="rooms" required>
                                <option value='0'>{{ __('Select Room') }}</option>
                                <option v-for='data in rooms' :value='data.id' :key="data.id">{{ data.name }}</option>
                            </select>
                            <div :class="loadingRooms ? 'col-lg-1 text-center' : 'd-none'">
                                <div class="spinner-border mt-2" style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <!-- Interrupt -->
                    <div class="form-group">
                        <div class="row">
                            <label style="width: 100%;">{{ __('Can it be interrupted?') }} *</label>
                            <div class="form-check col-lg-6">
                                <input class="form-check-input" type="radio" name="interrupRadios" id="yes" value="true" v-model="canInterrup">
                                <label class="form-check-label" for="yes">
                                    {{ __('Yes') }}
                                </label>
                            </div>
                            <div class="form-check col-lg-6">
                                <input class="form-check-input" type="radio" name="interrupRadios" id="no" value="false" v-model="canInterrup">
                                <label class="form-check-label" for="no">
                                    {{ __('No') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Services -->
                    <div class="form-group">
                        <div class="row">
                            <label for="services" style="width: 100%;">{{ __('Service Type') }} *</label>
                            <div class="form-check" v-for="data in services" :key="data.id" style="margin-right: 5%;">
                                <input class="form-check-input" type="checkbox" :name="data.name" :id="'service_' + data.id">
                                <label class="form-check-label" :value="data.id" :for="'service_' + data.id">{{ __(data.name) }}</label>
                            </div>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="form-group">
                        <div class="row">
                            <label for="request_content" style="width: 100%;">{{ __('Content') }}</label>
                            <input type="text" id="request_content" name="content" class="form-control col-lg-11" :value="content">
                        </div>
                    </div>
                    <!-- Persons -->
                    <div class="form-group">
                        <div class="row">
                            <label for="persons">{{ __('Number of persons') }} *</label>
                            <input type="number" id="persons" name="persons" class="form-control col-lg-11" v-model="persons" required>
                        </div>
                    </div>
                    <!-- Form buttons -->
                    <div class="row">
                        <div class="col-lg-3 text-left">
                            <button type="button" class="btn btn-outline-secondary" @click="save($event)">{{ __('Submit') }}</button>
                        </div>
                        <div class="col-lg-3 text-center">
                            <button type="button" class="btn btn-outline-primary" @click="saveAndSend($event)">{{ __('Submit and send') }}</button>
                        </div>
                        <div class="col-lg-3 text-right">
                            <a class="btn btn-outline-danger" :href="back" v-if="status === 'Draft'">{{ __('Cancel') }}</a>
                            <a class="btn btn-outline-danger" v-else data-toggle="modal" data-target="#cancelRequestModal">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="cancelRequestModal" tabindex="-1" role="dialog" aria-labelledby="cancelRequestModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelRequestModalLabel">{{ __('Caution') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ __('You are going to cancel the request, do you want to continue?') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModal">{{ __('No') }}</button>
                            <button type="button" class="btn btn-danger" @click="cancelRequest($event)">{{ __('Yes') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                companies: [],
                company: this.companyValue,
                plants: [],
                plant: this.plantValue,
                costCenters: [],
                center: this.costCenterValue,
                loadingPlants: false,
                loadingCostCenter: false,
                loadingApprovers: false,
                approvers: [],
                contacts: [],
                contact: this.contactValue,
                reason: this.reasonValue,
                content: this.contentValue,
                persons: this.personsValue,
                loadingContacts: false,
                start_date: null,
                start_time: null,
                end_date: null,
                end_time: null,
                rooms: [],
                room: this.roomValue,
                loadingRooms: false,
                canInterrup: 'true',
                services: [],
                loadingServices: false,
                requestObj: {},
                request: ['company', 'plant', 'center', 'contact', 'reason', 'room', 'content', 'persons', 'type'],
                errors: [],
                setValues: false
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
            getContacts() {
                this.loadingContacts = true;
                axios.get('/list/contacts')
                    .then((response) => {
                        this.loadingContacts = false;
                        this.contacts = response.data;
                    });
            },
            getRooms() {
                this.loadingRooms = true;
                axios.get(`/list/rooms/${this.plant}`)
                    .then((response) => {
                        this.loadingRooms = false;
                        this.rooms = response.data;
                    });
            },
            getServices() {
                this.loadingServices = true;
                axios.get('/list/services')
                    .then((response) => {
                        this.loadingServices = false;
                        this.services = response.data;
                    });
            },
            save(e) {
                this.mountRequestObject();
                if (this.checkForm()) {
                    this.requestObj.type = 'Draft';
                    this.hideModalAndShowLoading();
                    axios.put(this.update, JSON.stringify(this.requestObj), {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        }
                    }).then(response => this.showAlertAndRedirect())
                    .catch(error => {
                        console.error("There was an error!", error);
                    });
                }
                e.preventDefault();
            },
            saveAndSend(e) {
                this.mountRequestObject();
                if (this.checkForm()) {
                    this.requestObj.type = 'Pending';
                    this.hideModalAndShowLoading();
                    axios.put(this.update, JSON.stringify(this.requestObj), {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        }
                    }).then(response => this.showAlertAndRedirect())
                    .catch(error => {
                        console.error("There was an error!", error);
                    });
                }
                e.preventDefault();
            },
            cancelRequest(e) {
                this.requestObj.type = 'Cancelled';
                this.hideModalAndShowLoading();
                axios.put(`/state/request/${this.requestId}`, JSON.stringify(this.requestObj), {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                }).then(response => this.showAlertAndRedirect())
                .catch(error => {
                    console.error("There was an error!", error);
                });
                e.preventDefault();
            },
            mountRequestObject() {
                this.requestObj._token = this.csrfToken;
                this.requestObj.id = this.requestId;
                this.requestObj.canInterrup = (this.canInterrup === 'true') ? true : false;
                this.requestObj.start_date = `${this.start_date} ${this.start_time}:00`;
                this.requestObj.end_date = `${this.end_date} ${this.end_time}:00`;
                this.requestObj.approvers = this.approvers;
                this.requestObj.services = [];
                this.services.forEach(elem => {
                    if (document.getElementById(`service_${elem.id}`).checked) {
                        this.requestObj.services.push(elem.id);
                    }
                });
                this.request.forEach(elem => {
                    this.requestObj[elem] = this.$data[elem];
                });
            },
            checkForm() {
                if (this.company && this.company !== '0' && this.plant && this.plant !== '0' && this.center 
                    && this.center !== '0' && this.contact && this.contact !== '0' && this.reason && this.start_date
                    && this.start_time && this.end_date && this.end_time && this.room && this.room !== '0'
                    && this.requestObj.services.length > 0 && this.persons) {
                    return true;
                }

                this.errors = [];

                if (!this.company || this.company === '0') {
                    this.errors.push('Choose a company.');
                }
                if (!this.plant || this.plant === '0') {
                    this.errors.push('Choose a plant.');
                }
                if (!this.center || this.center === '0') {
                    this.errors.push('Choose a cost center.');
                }
                if (!this.contact || this.contact === '0') {
                    this.errors.push('Choose a contact.');
                }
                if (!this.reason) {
                    this.errors.push('Write a reason.');
                }
                if (!this.start_date || !this.start_time) {
                    this.errors.push('Define the start day and time.');
                }
                if (!this.end_date || !this.end_time) {
                    this.errors.push('Define the end day and time.');
                }
                if (!this.room || this.room === '0') {
                    this.errors.push('Choose a room.');
                }
                if (this.requestObj.services.length === 0) {
                    this.errors.push('Choose the type (s) of service (s).');
                }
                if (!this.persons) {
                    this.errors.push('Enter the number of persons.');
                }
                
                window.scrollTo(0,0);

                return false;
            },
            setFormValues() {
                // Set services checkbox
                const selServices = JSON.parse(this.selectedServices);
                selServices.forEach(service => {
                    if (document.getElementById(`service_${service.service_types_id}`)) {
                        document.getElementById(`service_${service.service_types_id}`).checked = true;
                        this.setValues = true;
                    }
                });
                // Set interrump radios
                (this.interrump === '0') ? this.canInterrup = 'false' : null;
                if (!this.start_date) {
                    this.start_date = this.start.split(' ')[0];
                    this.start_time = this.start.split(' ')[1].replace(':00', '');
                    this.end_date = this.end.split(' ')[0];
                    this.end_time = this.end.split(' ')[1].replace(':00', '');
                }
            },
            resetRelations() {
                this.plant = '0';
                this.plants = [];
                this.getPlants();
                this.costCenters = [];
                this.center = '0';
                this.room = '0';
                this.rooms = [];
                this.getApprovers();
            },
            resetPlantRelations() {
                this.center ='0';
                this.room = '0';
                this.getCostCenter();
                this.getRooms();
            },
            hideModalAndShowLoading() {
                document.getElementById('closeModal').click();
                document.getElementById('loading').style.display = 'block';
            },
            showAlertAndRedirect() {
                window.scrollTo(0,0);
                document.getElementById('edit-alert').classList.remove('d-none');
                setTimeout(() => {
                    window.location.href = '/requests';
                }, 2000)
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
            },
            back: {
                type: String,
                required: true
            },
            companyValue: {
                type: String,
                required: true
            },
            plantValue: {
                type: String,
                required: true
            },
            costCenterValue: {
                type: String,
                required: true
            },
            reasonValue: {
                type: String,
                required: true
            },
            contactValue: {
                type: String,
                required: true
            },
            roomValue: {
                type: String,
                required: true
            },
            contentValue: {
                type: String,
                required: true
            },
            personsValue: {
                type: String,
                required: true
            },
            interrump: {
                type: String,
                required: true
            },
            selectedServices: {
                type: String,
                required: true
            },
            start: {
                type: String,
                required: true
            },
            end: {
                type: String,
                required: true
            },
            requestId: {
                type: String,
                required: true
            },
            update: {
                type: String,
                required: true
            },
            status: {
                type: String,
                required: true
            }
        },
        created() {
            this.getCompanies();
            this.getCostCenter();
            this.getServices();
            this.getContacts();
            this.getPlants();
            this.getApprovers();
            this.getRooms();
        },
        updated() {
            if (!this.setValues) this.setFormValues();
        }
    }
</script>
