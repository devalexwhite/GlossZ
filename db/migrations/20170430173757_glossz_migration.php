<?php

use Phinx\Migration\AbstractMigration;

class GlosszMigration extends AbstractMigration
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
    public function change()
    {
        $user_table = $this->table('user');
        $user_table
                ->addColumn('username','string',
                    array('null' => false))
                ->addColumn('email','string',
                    array('null' => false))
                ->addColumn('password','string',
                    array('null' => false))
                ->addColumn('is_deleted','boolean', 
                    array('null' => false, 'default'=>false))
                ->addTimestamps()
                ->create();

        $glossary_table = $this->table('glossary');
        $glossary_table
                ->addColumn('title','string',
                    array('null' => false))
                ->addColumn('user_id','integer')
                ->addForeignKey('user_id','user','id')
                ->addColumn('is_deleted','boolean', 
                    array('null' => false, 'default'=>false))
                ->addTimestamps()
                ->create();

        $term_table = $this->table('term');
        $term_table
                ->addColumn('value','string',
                    array('null' => false))
                ->addColumn('glossary_id', 'integer')
                ->addForeignKey('glossary_id','glossary','id')
                ->addColumn('user_id','integer')
                ->addForeignKey('user_id','user','id')
                ->addColumn('is_deleted','boolean', 
                    array('null' => false, 'default'=>false))
                ->addTimestamps()
                ->create();
        
        $language_table = $this->table('language');
        $language_table
                ->addColumn('full_name','string',
                    array('null' => false))
                ->addColumn('short_name','string',
                    array('null' => false))
                ->create();
        
        $translation_table = $this->table('translation');
        $translation_table
                ->addColumn('value','string',
                    array('null' => false))
                ->addColumn('language_id', 'integer')
                ->addForeignKey('language_id','language','id')
                ->addColumn('term_id', 'integer')
                ->addForeignKey('term_id','term','id')
                ->addColumn('user_id','integer')
                ->addForeignKey('user_id','user','id')
                ->addColumn('is_deleted','boolean', 
                    array('null' => false, 'default'=>false))
                ->addTimestamps()
                ->create();
    }
}
