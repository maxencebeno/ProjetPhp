<?php

/*
	*
	Fonction qui sert א יviter א l'utilisateur de re-saisir toutes les infos si seulement un champ ne va pas.
	*
*/
function pre_remplir($valeurChamp){
	if(isset($valeurChamp)){
		if(!empty($valeurChamp)){
				return 'value="'.$valeurChamp.'"';
		}else{
			return '';
		}
	}else{
		return '';
	}
}