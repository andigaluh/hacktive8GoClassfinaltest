package models

import (
	"errors"
	"html"
	"strings"
	"time"

	"github.com/jinzhu/gorm"
)

type Statis struct {
	ID        uint64    `gorm:"primary_key;auto_increment" json:"id"`
	Title     string    `gorm:"size:255;not null;unique" json:"title"`
	Content   string    `gorm:"size:255;not null" json:"content"`
	Author    User      `json:"author"`
	IsPublish uint      `gorm:"not null" json:"is_publish"`
	AuthorID  uint32    `gorm:"not null" json:"author_id"`
	CreatedAt time.Time `gorm:"default:CURRENT_TIMESTAMP" json:"created_at"`
	UpdatedAt time.Time `gorm:"default:CURRENT_TIMESTAMP" json:"updated_at"`
}

func (p *Statis) Prepare() {
	p.ID = 0
	p.Title = html.EscapeString(strings.TrimSpace(p.Title))
	p.Content = html.EscapeString(strings.TrimSpace(p.Content))
	p.Author = User{}
	p.IsPublish = 0
	p.CreatedAt = time.Now()
	p.UpdatedAt = time.Now()
}

func (p *Statis) Validate() error {
	if p.Title == "" {
		return errors.New("Required Title")
	}
	if p.Content == "" {
		return errors.New("Required Content")
	}
	if p.AuthorID < 1 {
		return errors.New("Required Author")
	}

	return nil
}

func (p *Statis) SaveStatis(db *gorm.DB) (*Statis, error) {
	var err error
	err = db.Debug().Model(&Statis{}).Create(&p).Error
	if err != nil {
		return &Statis{}, err
	}
	if p.ID != 0 {
		err = db.Debug().Model(&User{}).Where("id = ?", p.AuthorID).Take(&p.Author).Error
		if err != nil {
			return &Statis{}, err
		}
	}
	return p, nil
}

func (p *Statis) FindAllStatis(db *gorm.DB) (*[]Statis, error) {
	var err error
	posts := []Statis{}
	err = db.Debug().Model(&Statis{}).Limit(100).Find(&posts).Error
	if err != nil {
		return &[]Statis{}, err
	}
	if len(posts) > 0 {
		for i, _ := range posts {
			err := db.Debug().Model(&User{}).Where("id = ?", posts[i].AuthorID).Take(&posts[i].Author).Error
			if err != nil {
				return &[]Statis{}, err
			}
		}
	}
	return &posts, nil
}

func (p *Statis) FindStatisByID(db *gorm.DB, pid uint64) (*Statis, error) {
	var err error
	err = db.Debug().Model(&Statis{}).Where("id = ?", pid).Take(&p).Error
	if err != nil {
		return &Statis{}, err
	}
	if p.ID != 0 {
		err = db.Debug().Model(&User{}).Where("id = ?", p.AuthorID).Take(&p.Author).Error
		if err != nil {
			return &Statis{}, err
		}
	}
	return p, nil
}

func (p *Statis) UpdateAStatis(db *gorm.DB) (*Statis, error) {
	var err error
	err = db.Debug().Model(&Statis{}).Where("id = ?", p.ID).Updates(Statis{Title: p.Title, Content: p.Content, UpdatedAt: time.Now()}).Error
	if err != nil {
		return &Statis{}, err
	}
	if p.ID != 0 {
		err = db.Debug().Model(&User{}).Where("id = ?", p.AuthorID).Take(&p.Author).Error
		if err != nil {
			return &Statis{}, err
		}
	}
	return p, nil
}

func (p *Statis) DeleteAStatis(db *gorm.DB, pid uint64, uid uint32) (int64, error) {
	db = db.Debug().Model(&Statis{}).Where("id = ? and author_id = ?", pid, uid).Take(&Statis{}).Delete(&Statis{})

	if db.Error != nil {
		if gorm.IsRecordNotFoundError(db.Error) {
			return 0, errors.New("Content statis not found")
		}
		return 0, db.Error
	}
	return db.RowsAffected, nil
}

func (p *Statis) FindAllPublishStatis(db *gorm.DB) (*[]Statis, error) {
	var err error
	var PublishTrue uint
	PublishTrue = 1
	posts := []Statis{}
	err = db.Debug().Model(&Statis{}).Where("is_publish = ?", PublishTrue).Limit(100).Find(&posts).Error
	if err != nil {
		return &[]Statis{}, err
	}
	if len(posts) > 0 {
		for i, _ := range posts {
			err := db.Debug().Model(&User{}).Where("id = ?", posts[i].AuthorID).Take(&posts[i].Author).Error
			if err != nil {
				return &[]Statis{}, err
			}
		}
	}
	return &posts, nil
}

func (p *Statis) FindPublishStatisByID(db *gorm.DB, pid uint64) (*Statis, error) {
	var err error
	var PublishTrue uint
	PublishTrue = 1
	err = db.Debug().Model(&Statis{}).Where("id = ? and is_publish = ?", pid, PublishTrue).Take(&p).Error
	if err != nil {
		return &Statis{}, err
	}
	if p.ID != 0 {
		err = db.Debug().Model(&User{}).Where("id = ?", p.AuthorID).Take(&p.Author).Error
		if err != nil {
			return &Statis{}, err
		}
	}
	return p, nil
}
