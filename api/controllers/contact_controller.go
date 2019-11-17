package controllers

import (
	"encoding/json"
	_ "errors"
	"fmt"
	"io/ioutil"
	"net/http"
	_ "strconv"

	_ "github.com/andigaluh/hacktive8GoClassfullstack/api/auth"
	"github.com/andigaluh/hacktive8GoClassfullstack/api/models"
	"github.com/andigaluh/hacktive8GoClassfullstack/api/responses"
	"github.com/andigaluh/hacktive8GoClassfullstack/api/utils/formaterror"
	_ "github.com/gorilla/mux"
)

func (server *Server) CreateContact(w http.ResponseWriter, r *http.Request) {
	body, err := ioutil.ReadAll(r.Body)
	if err != nil {
		responses.ERROR(w, http.StatusUnprocessableEntity, err)
		return
	}
	contact := models.Contact{}
	err = json.Unmarshal(body, &contact)
	if err != nil {
		responses.ERROR(w, http.StatusUnprocessableEntity, err)
		return
	}
	contact.Prepare()
	err = contact.Validate()
	if err != nil {
		responses.ERROR(w, http.StatusUnprocessableEntity, err)
		return
	}

	contactCreated, err := contact.SaveContact(server.DB)
	if err != nil {
		formattedError := formaterror.FormatError(err.Error())
		responses.ERROR(w, http.StatusInternalServerError, formattedError)
		return
	}
	w.Header().Set("Location", fmt.Sprintf("%s%s/%d", r.Host, r.URL.Path, contactCreated.ID))
	responses.JSON(w, http.StatusCreated, contactCreated)
}
