package seed

import (
	"log"

	"github.com/andigaluh/hacktive8GoClassfullstack/api/models"
	"github.com/jinzhu/gorm"
)

var users = []models.User{
	models.User{
		Nickname: "Andi galuh",
		Email:    "andy13galuh@gmail.com",
		Password: "password",
	},
	models.User{
		Nickname: "Afkar Ghanniyu",
		Email:    "afkar.ghanniyu@gmail.com",
		Password: "password",
	},
}

var posts = []models.Post{
	models.Post{
		Title:     "Title 1",
		Content:   "Hello world 1",
		IsPublish: 1,
	},
	models.Post{
		Title:     "Title 2",
		Content:   "Hello world 2",
		IsPublish: 1,
	},
}

var statises = []models.Statis{
	models.Statis{
		Title:     "About Us",
		Content:   "Hello world, this is about us page",
		IsPublish: 1,
	},
}

func Load(db *gorm.DB) {

	err := db.Debug().DropTableIfExists(&models.Post{}, &models.User{}, &models.Statis{}, &models.Contact{}).Error
	if err != nil {
		log.Fatalf("cannot drop table: %v", err)
	}
	err = db.Debug().AutoMigrate(&models.User{}, &models.Post{}, &models.Statis{}, &models.Contact{}).Error
	if err != nil {
		log.Fatalf("cannot migrate table: %v", err)
	}

	err = db.Debug().Model(&models.Post{}).AddForeignKey("author_id", "users(id)", "cascade", "cascade").Error
	if err != nil {
		log.Fatalf("attaching foreign key error: %v", err)
	}

	err = db.Debug().Model(&models.Statis{}).AddForeignKey("author_id", "users(id)", "cascade", "cascade").Error
	if err != nil {
		log.Fatalf("attaching foreign key error: %v", err)
	}

	for i, _ := range users {
		err = db.Debug().Model(&models.User{}).Create(&users[i]).Error
		if err != nil {
			log.Fatalf("cannot seed users table: %v", err)
		}
		posts[i].AuthorID = users[i].ID
		statises[i].AuthorID = users[i].ID

		err = db.Debug().Model(&models.Post{}).Create(&posts[i]).Error
		if err != nil {
			log.Fatalf("cannot seed posts table: %v", err)
		}

		err = db.Debug().Model(&models.Statis{}).Create(&statises[i]).Error
		if err != nil {
			log.Fatalf("cannot seed Statis table: %v", err)
		}
	}
}
