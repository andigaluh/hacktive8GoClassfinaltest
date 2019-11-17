package models

import (
	"errors"
	"html"
	"strings"
	"time"

	"github.com/jinzhu/gorm"
)

type Contact struct {
	ID        uint64    `gorm:"primary_key;auto_increment" json:"id"`
	Name      string    `gorm:"size:255;not null" json:"name"`
	Email     string    `gorm:"size:255;not null" json:"email"`
	Message   string    `gorm:"type:text" json:"message"`
	CreatedAt time.Time `gorm:"default:CURRENT_TIMESTAMP" json:"created_at"`
	UpdatedAt time.Time `gorm:"default:CURRENT_TIMESTAMP" json:"updated_at"`
}

func (p *Contact) Prepare() {
	p.ID = 0
	p.Name = html.EscapeString(strings.TrimSpace(p.Name))
	p.Email = html.EscapeString(strings.TrimSpace(p.Email))
	p.Message = html.EscapeString(strings.TrimSpace(p.Message))
	p.CreatedAt = time.Now()
	p.UpdatedAt = time.Now()
}

func (p *Contact) Validate() error {
	if p.Name == "" {
		return errors.New("Required Name")
	}
	if p.Email == "" {
		return errors.New("Required Email")
	}

	return nil
}

func (p *Contact) SaveContact(db *gorm.DB) (*Contact, error) {
	var err error
	err = db.Debug().Model(&Contact{}).Create(&p).Error
	if err != nil {
		return &Contact{}, err
	}

	return p, nil
}
