<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="#" class="form newtopic" @submit.prevent="checkForm">
                    <p v-if="errors.length">
                        <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </p>
                    <div class="form-group">
                        <label>Select Company:</label>
                        <select class='form-control' v-model='company' @change='getPlants()'>
                            <option value='0' >Select company</option>
                            <option v-for='data in companies' :value='data.id'>{{ data.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Plant:</label>
                        <select class='form-control' v-model='plant'>
                            <option value='0'>Select Plant</option>
                            <option v-for='data in plants' :value='data.id'>{{ data.name }}</option>
                        </select>
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
                errors: [],
                company: null,
                plant: null,
                companies: [],
                plants: []
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
                axios.get(`/list/plants/${this.company}`)
                    .then((response) => {
                        this.plants = response.data;
                    });
            },
            checkForm(e) {
                if (this.company && this.plant) {
                    console.log('OK');
                    return true;
                }

                this.errors = [];
                if (!this.company) {
                    this.errors.push('La compañia es obligatoria!');
                }
                if (!this.plant) {
                    this.errors.push('La planta es obligatoria!');
                }

                e.preventDefault();
            }
        },
        created() {
            this.getCompanies()
        }
    }
</script>
