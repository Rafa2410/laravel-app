<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                            </tr>
                            <tr v-for="company in companies" :key="company.id">
                                <td>{{ company.id }}</td>
                                <td>{{ company.name }}</td>
                            </tr>
                        </table>
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
                companies: {},
            }
        },
        methods: {
            getCompanies() {
                axios.get('/requests/list')
                    .then((response) => {
                        console.log('Response',response)
                        this.companies = response.data.companies;
                    })
            }
        },
        created() {
            this.getCompanies()
        }
    }
</script>
