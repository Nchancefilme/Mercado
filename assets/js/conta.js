        let nome = document.querySelector(".nome");
        let entidade = document.getElementById("entidade");
        let data = document.querySelector(".data");
        let dataLabel = document.querySelector(".dataLabel");
        let genero = document.getElementById("genero");
        let naturalidade = document.getElementById("naturalidade");
        let nomeInstituicao = document.getElementById("nomeInstituicao");
        let provincia = document.getElementById("provincia");
        let localizacao = document.getElementById("localizacao");
        let cell_1 = document.getElementById("cell-1");
        let cell_2 = document.getElementById("cell-2");
        let btn = document.getElementById("btn");

        nome.style.display = "none";
        dataLabel.style.display = "none";
        data.style.display = "none";
        genero.style.display = "none";
        naturalidade.style.display = "none";
        provincia.style.display = "none";
        localizacao.style.display = "none";
        cell_1.style.display = "none";
        cell_2.style.display = "none";
        btn.style.display = "none";      
        
        entidade.addEventListener('change', function(){
            if(this.value != "comum" && this.value !=""){
                dataLabel.style.display = "none";
                data.style.display = "none";
                genero.style.display = "none";
                naturalidade.style.display = "none";
                nome.style.display = "block";
                provincia.style.display = "block";
                localizacao.style.display = "block";
                cell_1.style.display = "block";
                cell_2.style.display = "block";
                btn.style.display = "block";
               
            }
        })
        
        entidade.addEventListener('change', function(){
            if(this.value == "comum" || this.value == ""){
                nome.style.display = "block";
                dataLabel.style.display = "block";
                data.style.display = "block";
                genero.style.display = "block";
                naturalidade.style.display = "block";
                provincia.style.display = "none";
                localizacao.style.display = "none";
                cell_1.style.display = "block";
                cell_2.style.display = "block";
                btn.style.display = "block";
            }
        })

        entidade.addEventListener('change', function(){
            if(this.value == ""){
                nome.style.display = "none";
                dataLabel.style.display = "none";
                data.style.display = "none";
                genero.style.display = "none";
                naturalidade.style.display = "none";
                provincia.style.display = "none";
                localizacao.style.display = "none";
                cell_1.style.display = "none";
                cell_2.style.display = "none";
                btn.style.display = "none";
            }
        })

        // console.log(data, entidade[1].value)