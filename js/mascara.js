			function fMasc(objeto,mascara) 
			{
				obj=objeto
				masc=mascara
				setTimeout("fMascEx()",1)
			}
			function fMascEx() 
			{
				obj.value=masc(obj.value)
			}
			function mTel(tel) 
			{
				tel=tel.replace(/\D/g,"")
				tel=tel.replace(/^(\d)/,"($1")
				tel=tel.replace(/(.{3})(\d)/,"$1) $2")
				if(tel.length == 9) {
					tel=tel.replace(/(.{1})$/,"-$1")
				} else if (tel.length == 10) {
					tel=tel.replace(/(.{2})$/,"-$1")
				} else if (tel.length == 11) {
					tel=tel.replace(/(.{3})$/,"-$1")
				} else if (tel.length == 12) {
					tel=tel.replace(/(.{4})$/,"-$1")
				} else if (tel.length > 12) {
					tel=tel.replace(/(.{4})$/,"-$1")
				}
				return tel;
			}
			function mCNPJ(cnpj)
			{
				cnpj=cnpj.replace(/\D/g,"")
				cnpj=cnpj.replace(/^(\d{2})(\d)/,"$1.$2")
				cnpj=cnpj.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
				cnpj=cnpj.replace(/\.(\d{3})(\d)/,".$1/$2")
				cnpj=cnpj.replace(/(\d{4})(\d)/,"$1-$2")
				return cnpj
			}
			function mCPF(cpf)
			{
				cpf=cpf.replace(/\D/g,"")
				cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
				cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
				cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
				return cpf
			}
			function mCEP(cep)
			{
				cep=cep.replace(/\D/g,"")
				cep=cep.replace(/^(\d{2})(\d)/,"$1.$2")
				cep=cep.replace(/\.(\d{3})(\d)/,".$1-$2")
				return cep
			}
			function mNum(num)
			{
				num=num.replace(/\D/g,"")
				return num
			}

			 function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){  
			     var sep = 0;  
			     var key = '';  
			     var i = j = 0;  
			     var len = len2 = 0;  
			     var strCheck = '0123456789';  
			     var aux = aux2 = '';  
			     var whichCode = (window.Event) ? e.which : e.keyCode;  
			     if (whichCode == 13 || whichCode == 8) return true;  
			     key = String.fromCharCode(whichCode); // Valor para o código da Chave  
			     if (strCheck.indexOf(key) == -1) return false; // Chave inválida  
			     len = objTextBox.value.length;  
			     for(i = 0; i < len; i++)  
			         if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;  
			     aux = '';  
			     for(; i < len; i++)  
			         if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);  
			     aux += key;  
			     len = aux.length;  
			     if (len == 0) objTextBox.value = '';  
			     if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;  
			     if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;  
			     if (len > 2) {  
			         aux2 = '';  
			         for (j = 0, i = len - 3; i >= 0; i--) {  
			             if (j == 3) {  
			                 aux2 += SeparadorMilesimo;  
			                 j = 0;  
			             }  
			             aux2 += aux.charAt(i);  
			             j++;  
			         }  
			         objTextBox.value = '';  
			         len2 = aux2.length;  
			         for (i = len2 - 1; i >= 0; i--)  
			         objTextBox.value += aux2.charAt(i);  
			         objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);  
			     }  
			     return false;  
			 }  