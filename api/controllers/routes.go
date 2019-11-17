package controllers

import "github.com/andigaluh/hacktive8GoClassfullstack/api/middlewares"

func (s *Server) initializeRoutes() {

	// Home Route
	s.Router.HandleFunc("/", middlewares.SetMiddlewareJSON(s.Home)).Methods("GET")

	// Login Route
	s.Router.HandleFunc("/login", middlewares.SetMiddlewareJSON(s.Login)).Methods("POST")

	//Users routes
	s.Router.HandleFunc("/users", middlewares.SetMiddlewareJSON(s.CreateUser)).Methods("POST")
	s.Router.HandleFunc("/users", middlewares.SetMiddlewareJSON(s.GetUsers)).Methods("GET")
	s.Router.HandleFunc("/users/{id}", middlewares.SetMiddlewareJSON(s.GetUser)).Methods("GET")
	s.Router.HandleFunc("/users/{id}", middlewares.SetMiddlewareJSON(middlewares.SetMiddlewareAuthentication(s.UpdateUser))).Methods("PUT")
	s.Router.HandleFunc("/users/{id}", middlewares.SetMiddlewareAuthentication(s.DeleteUser)).Methods("DELETE")

	//Posts routes
	s.Router.HandleFunc("/posts", middlewares.SetMiddlewareJSON(middlewares.SetMiddlewareAuthentication(s.CreatePost))).Methods("POST")
	//s.Router.HandleFunc("/posts", middlewares.SetMiddlewareJSON(s.GetPosts)).Methods("GET")
	s.Router.HandleFunc("/posts", middlewares.SetMiddlewareJSON(s.GetPublishPosts)).Methods("GET")
	s.Router.HandleFunc("/postsAll", middlewares.SetMiddlewareJSON(s.GetPosts)).Methods("GET")
	//s.Router.HandleFunc("/posts/{id}", middlewares.SetMiddlewareJSON(s.GetPost)).Methods("GET")
	s.Router.HandleFunc("/posts/{id}", middlewares.SetMiddlewareJSON(s.GetPublishPost)).Methods("GET")
	s.Router.HandleFunc("/postsAll/{id}", middlewares.SetMiddlewareJSON(s.GetPost)).Methods("GET")
	s.Router.HandleFunc("/postsUpdate/{id}", middlewares.SetMiddlewareJSON(middlewares.SetMiddlewareAuthentication(s.UpdatePost))).Methods("POST")
	s.Router.HandleFunc("/posts/{id}", middlewares.SetMiddlewareJSON(middlewares.SetMiddlewareAuthentication(s.UpdatePost))).Methods("PUT")
	s.Router.HandleFunc("/posts/{id}", middlewares.SetMiddlewareAuthentication(s.DeletePost)).Methods("DELETE")

	//Statis routes
	s.Router.HandleFunc("/statis/{id}", middlewares.SetMiddlewareJSON(s.GetPublishStatis)).Methods("GET")
	//s.Router.HandleFunc("/posts", middlewares.SetMiddlewareJSON(s.CreatePost)).Methods("POST")
	//s.Router.HandleFunc("/posts", middlewares.SetMiddlewareJSON(s.GetPosts)).Methods("GET")
	//s.Router.HandleFunc("/statis", middlewares.SetMiddlewareJSON(s.GetPublishStatises)).Methods("GET")
	//s.Router.HandleFunc("/posts/{id}", middlewares.SetMiddlewareJSON(s.GetPost)).Methods("GET")
	//s.Router.HandleFunc("/posts/{id}", middlewares.SetMiddlewareJSON(middlewares.SetMiddlewareAuthentication(s.UpdatePost))).Methods("PUT")
	//s.Router.HandleFunc("/posts/{id}", middlewares.SetMiddlewareAuthentication(s.DeletePost)).Methods("DELETE")

	//Contact routes
	s.Router.HandleFunc("/contact", middlewares.SetMiddlewareJSON(s.CreateContact)).Methods("POST")
}
