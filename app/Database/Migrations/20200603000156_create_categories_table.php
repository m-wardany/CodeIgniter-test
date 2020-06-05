<?php namespace App\Database\Migrations;

class AddBCategory extends \CodeIgniter\Database\Migration {

        public function up()
        {
                $this->forge->addField([
                        'id'          => [
                                'type'           => 'INT',
                                'constraint'     => 11,
                                'unsigned'       => TRUE,
                                'auto_increment' => TRUE
                        ],
                        'name'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '100',
                        ],
                        'parent_id'          => [
                            'type'           => 'INT',
                            'constraint'     => 11,
                            'unsigned'       => TRUE,
                            'NULL'           => true   
                        ],
                        'seq'          => [
                            'type'           => 'INT',
                            'constraint'     => 11,
                            'unsigned'       => TRUE,
                            'default'        => 1
                        ],
                        'lft'          => [
                            'type'           => 'INT',
                            'constraint'     => 11,
                            'unsigned'       => TRUE,
                            'default'        => 0
                        ],
                        'rgt'          => [
                            'type'           => 'INT',
                            'constraint'     => 11,
                            'unsigned'       => TRUE,
                            'default'        => 1
                        ],
                        'depth'          => [
                            'type'           => 'INT',
                            'constraint'     => 11,
                            'unsigned'       => TRUE,
                            'default'        => 0
                        ],
                        'tree'          => [
                            'type'           => 'INT',
                            'constraint'     => 11,
                            'unsigned'       => TRUE,
                            'default'        => 1
                        ],
                ]);
                $this->forge->addKey('id', TRUE);
                $this->forge->createTable('categories');

                $this->db->query("INSERT INTO categories(name, tree, depth, seq) VALUES('Category A', 1, 0, 1),('Category B', 2, 0, 2);");
        }

        public function down()
        {
                $this->forge->dropTable('categories');
        }
}