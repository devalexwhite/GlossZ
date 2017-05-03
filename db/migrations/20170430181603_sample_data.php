<?php

use Phinx\Migration\AbstractMigration;

class SampleData extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $users = [
            [
                'username' => 'devalexwhite',
                'email' => 'devalexwhite@gmail.com',
                'password' => 'test'
            ]
        ];

        $this->table('user')->insert($users)->save();

        $glossaries = [
            [
                'title' => 'Sample glossary 1',
                'user_id' => 1
            ]
        ];

        $this->table('glossary')->insert($glossaries)->save();

        $terms = [
            [
                'value' => 'Sushi',
                'glossary_id' => 1,
                'user_id' => 1
            ],
            [
                'value' => 'Taco',
                'glossary_id' => 1,
                'user_id' => 1
            ],
            [
                'value' => 'Job',
                'glossary_id' => 1,
                'user_id' => 1
            ]
        ];

        $this->table('term')->insert($terms)->save();

        $languages = [
            [
                'full_name' => 'English',
                'short_name' => 'en'
            ],
            [
                'full_name' => 'Chinese',
                'short_name' => 'cn'
            ],
            [
                'full_name' => 'Japanese',
                'short_name' => 'jp'
            ],
            [
                'full_name' => 'Spanish',
                'short_name' => 'es'
            ]
        ];

        $this->table('language')->insert($languages)->save();


        $translations = [
            [
                'value' => '寿司',
                'term_id' => 1,
                'language_id' => 3,
                'user_id' => 1
            ],
            [
                'value' => '塔科',
                'term_id' => 2,
                'language_id' => 2,
                'user_id' => 1
            ],
            [
                'value' => 'タコス',
                'term_id' => 2,
                'language_id' => 3,
                'user_id' => 1
            ]
        ];

        $this->table('translation')->insert($translations)->save();
    }

    public function down() {
        $this->execute("DELETE FROM user");
        $this->execute("DELETE FROM glossary");
        $this->execute("DELETE FROM term");
        $this->execute("DELETE FROM translation");
        $this->execute("DELETE FROM language");
    }
}
