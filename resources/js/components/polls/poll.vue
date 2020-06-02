<template>
    <div class="container">
   <div class="card">
      <div class="card-content">
         <div class="card-header">
            <div class="card-title">
               <h2>{{ poll.name }}</h2>
            </div>
         </div>
         <div class="card-body">
            <div v-if="activeQuestion == null" v-cloak style="display: none">
               <p>{{ poll.description }}</p>
               <!-- <div class="form-group">
                   <label>Tu nombre:</label>
                   <input class="form-control" v-model="event.name" type="text" /><small>{{ $vmv.event.name.$error }}</small>
                </div>
               <div class="form-group">
                   <label>Tu correo electrónico:</label>
                   <input class="form-control" v-model="event.email" type="email" /><small>{{ $vmv.event.email.$error }}</small>
                </div>
               <div class="form-group">
                   <label>Tu empresa:</label>
                   <input class="form-control" v-model="event.enterprise" type="email" /><small>{{ $vmv.event.enterprise.$error }}</small>
                </div>
               <div class="form-group">
                  <div class="form-check m-4">
                      <input class="form-check-input" type="checkbox" v-model="event.member" value="true" if="defaultCheckMember" />
                      <label class="form-check-label" for="'defaultCheckMember'">Eres miembro</label>
                    </div>
               </div> -->
            </div>
            <p v-if="activeQuestion == 'End'">Gracias por tus respuestas, nos ayudan a mejorar nuestros servicios.</p>
            <div v-if="activeQuestion != null &amp;&amp; activeQuestion != 'End'">
               <h4>{{ index + 1 }}. <i>{{ activeQuestion.question }}</i></h4>
               <div v-if="activeQuestion.type == 'multiple'">
                  <div class="custom-control custom-checkbox" v-for="(option, i) in activeQuestion.options" :key="i" >
                     <input class="custom-control-input" type="checkbox" v-model="answer.answer" :value="option.option" :id="'defaultCheck' + option.id" />
                     <label class="custom-control-input" :for="'defaultCheck' + option.id">{{ option.option }}</label>
                  </div>
               </div>
               <div v-if="activeQuestion.type == 'option'" class="tab-content">
                  <div class="custom-control custom-radio mb-3" v-for="(option, index) in activeQuestion.options" :key="index">
                     <input class="custom-control-input" type="radio" v-model="answer.answer" :value="option.option" :id="'defaultRadio' + option.id" :name="'defaultRadio' + option.id" />
                     <label class="custom-control-label" :for="'defaultRadio' + option.id">{{ option.option }}</label>
                  </div>
               </div>
               <div v-if="activeQuestion.type == 'open'">
                   <input class="form-control" type="text" placeholder="Tu respuesta aqui" v-model="answer.answer" />
                </div>
            </div>
         </div>
         <div class="card-footer">
            <div class="row">
               <div class="col-sm-10"></div>
               <div class="col-sm-2"><button class="btn btn-success pull-right" v-if="activeQuestion == null" @click="startPoll">Iniciar</button>
                  <button class="btn btn-success pull-right" v-if="activeQuestion != null &amp;&amp; activeQuestion != 'End'" @click="nextQuestion">Siguiente</button>
                  <button class="btn btn-success pull-right" v-if="activeQuestion == 'End' && submitted == false" @click="storeEvent">Enviar encuesta</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</template>

<style scoped>
    .question{
        background: #e8e8e8;
        border-radius: .4rem;
        padding: 1rem;
        margin: .5rem 0;
    }
    .option{
        background: #f1f1f1;
        margin: .5rem 0 1rem 0;
        padding: .5rem;
        display: block
    }
    .normal{
        font-size: 1rem !important;
    }
    .small{
        font-size: .8rem !important;
    }
    
    a.mdi, i {
        font-size: 22px !important;
    } 
    [v-cloak] > * { display:none; }
</style>
<script>
export default {
    props: {
        id: ''
    },
    validations: {
        event: {
            // email: { required: true, type: 'email' },
            // name: { required: true, minlen: 5 },
            wonumber: { required: true },
        },
    },
    data(){
        return {
            activeQuestion: null,
            answer: {},
            event: {
                answers: [],
            },
            poll: {},
            submitted: false,
            
        }
    },
    methods: {
        getPoll(){
            axios.get('/api/polls/KMESTF')
                .then(response => {
                    this.poll = response.data
                    this.event.poll_id = this.poll.id
                    // this.$vmv.$validate('event', () => {
                        this.index = 0
                        this.answer.question_id = this.poll.questions[0].id
                        this.activeQuestion = this.poll.questions[0]
                        this.event.wonumber = this.id;
                    // });
                })
        },
        startPoll(){
            this.showLoading()
            
            this.$vmv.$validate('event', () => {
                this.index = 0
                this.answer.question_id = this.poll.questions[0].id
                this.activeQuestion = this.poll.questions[0]
            });

            this.stopLoading()
        },
        nextQuestion(){
            if(this.answer.answer === undefined){
                Swal.fire({
                    icon: 'error',
                    title: 'Seleccione una respuesta',
                    showConfirmButton: false,
                    timer: 2500
                })
            }
            else{
                this.index++
                this.event.answers.push(JSON.parse(JSON.stringify(this.answer)))
                if(this.index < this.poll.questions.length){
                    this.answer.question_id = this.poll.questions[this.index].id
                    if(this.poll.questions[this.index].type == 'multiple'){
                        this.answer.answer = []
                    }else{
                        this.answer.answer = ''
                    }

                    this.activeQuestion = this.poll.questions[this.index]
                }else
                    this.activeQuestion = 'End'
            }
            
        },
        storeEvent(){
            this.showLoading()
            axios.post('/api/store-event', this.event).then(response => {
                this.stopLoading()
                this.event = {
                    answers: [],
                }
                this.submitted = true;
                Swal.fire({
                    icon: 'success',
                    title: 'Tu encuesta se ha guardado correctamente',
                    showConfirmButton: false,
                    timer: 2500
                })
            }).catch(errors => {
                this.stopLoading()

                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrió un error, por favor reportalo a nuestras redes sociales',
                    showConfirmButton: false,
                    timer: 2500
                })
            })
        }
    },
    mounted(){
        this.getPoll();

        let validationMessages = {
			type: 'Este no es un {rule} válido',
			required: 'Este campo es requerido',
		}

		this.$vmv.$setMessages(validationMessages);
    }
}
</script>