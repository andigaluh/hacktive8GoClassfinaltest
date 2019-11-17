package controllers

import (
	"net/http"

	"github.com/andigaluh/hacktive8GoClassfullstack/api/responses"
)

func (server *Server) Home(w http.ResponseWriter, r *http.Request) {
	responses.JSON(w, http.StatusOK, "Welcome to this awesome API")
}
