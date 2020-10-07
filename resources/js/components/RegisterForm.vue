<template>
    <div class="formRegister">
        <div class="alert alert-success" v-if="submitted.result">
            {{ submitted.message }}
        </div>
        <div v-else >
            <h3 class="text-center">Registre-se</h3>
            <div class="row" style="justify-content: center;" >
                <div class="col-md-6">
                    <form @submit.prevent="createUser">
                        <div class="form-group">
                            <label>Nome: <b color="red" class="require-class">*</b></label>
                            <input type="text" class="form-control" v-model="user.name" required aria-required="Nome obrigatório.">
                            <div v-if="errors.name" class="error-message">
                                <i>{{ errors.name }}</i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email:<b color="red" class="require-class">*</b></label>
                            <input type="email" class="form-control" v-model="user.email" required aria-required="O email precisa estar preenchido!">
                            <div v-if=" errors.email" class="error-message">
                                <i>{{ errors.email }}</i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>CPF:<b color="red" class="require-class">*</b></label>
                            <input type="text" class="form-control" v-mask="'###.###.###-##'" v-model="user.cpf" required="CPF obrigatório.">
                            <div v-if="errors.cpf" class="error-message">
                                <i>{{ errors.cpf }}</i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Telefone:</label>
                            <input type="text" class="form-control" v-mask="'(##)#####-####'" v-model="user.phone" >
                            <div v-if="errors.phone" class="error-message">
                                <i>{{ errors.phone }}</i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Digite ao menos 1 competências: <b color="red" class="require-class">*</b></label>
                            <vue-tags-input
                                v-model="tag"
                                fit
                                :tags="tags"
                                add-only-from-autocomplete
                                :autocomplete-items="filteredItems"
                                @tags-changed="newTags => tags = newTags"
                            />
                            <div v-if="errors.competences" class="error-message">
                                <i>{{ errors.competences }}</i>
                            </div>
                            <!-- </select> -->
                            <button type="submit" class="btn btn-primary col-12">Registre-se</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import FormError from './FormError.vue';
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
        props: {
            value: {
                type: Array,
                default: () => []
            }
        },
        components: {
            FormError, VueTagsInput
        },
        data() {
            return {
                submitted: {
                    result: false,
                    message: ''
                },
                persons: [],
                errors: {},
                tag: '',
                tags: this.value || [],
                autocompleteItems: [
                    {text: 'Controle Financeiro'},        
                    {text: 'Controle de estoque'}, 
                    {text: 'Desenvolvimento front end'}, 
                    {text: 'Banco de dados'}, 
                    {text: 'Desenvolvimento Back End'}, 
                    {text: 'DevOps'},
                    {text: 'Gerência de Projetos'}
                ],
                user: {
                    name: null,
                    competences: []
                }
            }
        },
        computed: {
            filteredItems() {
            return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
            },
        },
        methods: {
            async createUser() {
                this.user.competences = [...this.tags]

                await axios({
                    method: 'post',
                    url: 'http://127.0.0.1:8000/api/register',
                    data: this.user
                }).then((response) => {
                    this.errors = {}
                    this.submitted.result = true
                    this.submitted.message = "Registro efetuado com sucesso!" 
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                })
            },
            addTag() {
                if (this.tag && ! this.tags.includes(this.tag)) {
                    this.tags.push(this.tag);
                    this.tag = '';
                }
            }
        },
        watch : {
            tags(n, o) {
                this.$emit('input', n);
            }
        },
        mounted: function(){
            this.user.name = this.$route.params.name
        }
    }
</script>
<style scoped>
    .vue-tags-input[data-v-61d92e31]{
        max-width: 100%;
        margin-bottom: 25px;
    }
    .require-class, .error-message{
        margin: 5px;
        color: red;
        font-weight: bold;
    }
    .formRegister {
        margin-top: 0px;
        margin-bottom: 10px;
    }
    .alert-success{
        text-align: center;
    }
</style>