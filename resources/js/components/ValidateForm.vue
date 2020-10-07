<template>
    <div>
        <h3 class="text-center" style="margin:-20px">Painel Admin</h3><br/>
 
        <div class="search-wrapper">
            <input type="text" v-model="search" placeholder="Procurar.."/>
        </div><br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Competências</th>
                <th>Status</th>
                <th>validar</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in queryResults" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone }}</td>
                <td>{{ user.cpf }}</td>
                <td>
                    <vue-tags-input
                        :tags="user.competences"
                        readonly
                        placeholder=""
                        disabled
                    />
                </td>
                <td v-if="user.validate == 0" class="notValidate">{{ 'Não Validado' }}</td>
                <td v-else class="validate">{{ 'Validado' }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button  v-if="user.validate == 0" class="btn btn-info" @click="validateRegister(user.id)">Validar</button>
                        <button v-else class="btn " style="background-color:silverborder:nonecolor:black" >-</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import VueAxios from 'vue-axios'
    import axios from 'axios'
    import VueTagsInput from '@johmun/vue-tags-input'
    import fz from 'fuzzaldrin-plus'

    export default {
        components: {
            VueTagsInput
        },
        data() {
            return {
                tag: '',
                tags: [],
                users:null,
                search: ''
            }
        },
        created() {
            this.getAllUsersData()
        },
        methods: {
            getAllUsersData(){
                axios.get('http://127.0.0.1:8000/api/users')
                        .then(response => {
                            this.users = response.data
                        })
            },
            validateRegister(id) {
                axios
                    .put(`http://127.0.0.1:8000/api/validate/user/${id}`)
                    .then(response => {
                       this.getAllUsersData()
                    })
            }
        },
        computed: {
            queryResults() {
                if(!this.search) return this.users

                const preparedQuery = fz.prepareQuery(this.search)
                const scores = {}

                return this.users
                    .map((option, index) => {
                    const scorableFields = [
                        option.id,
                        option.name,
                        option.phone,
                        option.cpf,
                        option.email,
                        option.competences
                    ].map(toScore => fz.score(toScore, this.search, { preparedQuery }))

                    scores[option.id] = Math.max(...scorableFields)

                    return option
                    })
                    .filter(option => scores[option.id] > 1)
                    .sort((a, b) => scores[b.id] - scores[a.id])
            }
        },
        monted () {
            this.getAllUsersData()
        }
    }
</script>
<style scoped>
    .validate {
        font-weight: bolder;
        color: green;
    }

    .notValidate{
        font-weight: bolder;
        color: red;
    }
    i.ti-icon-close{
        display: none !important;
    }
    .ti-tag .ti-actions[data-v-61d92e31] {
        display: none;
    }
</style>