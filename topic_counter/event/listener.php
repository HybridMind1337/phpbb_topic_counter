<?php
namespace hybridmind\topic_counter\event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
    
    /** @var \phpbb\config\config */
    protected $config;
    
    /** @var \phpbb\template\template */
    protected $template;
    
    /** @var \phpbb\user */
    protected $user;
    
    protected $db;
    
    public function __construct(\phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db)
    {
        $this->config   = $config;
        $this->template = $template;
        $this->user     = $user;
        $this->db       = $db;
    }
    
    static public function getSubscribedEvents()
    {
        return array(
            'core.viewtopic_modify_post_row' => 'viewtopic_modify_post_row'
        );
    }
    
    public function viewtopic_modify_post_row($event)
    {
        $user_id = $event['poster_id'];
        $sqlz    = 'SELECT COUNT(topic_id) AS broika FROM phpbb_topics WHERE topic_poster=' . $user_id . '';
        $result3 = $this->db->sql_query($sqlz);
        $rowz2   = $this->db->sql_fetchrow($result3);
        $this->db->sql_freeresult($result3);
        $getglobaltopics = $rowz2['broika'];
        
        
        $event['post_row'] = array_merge($event['post_row'], array(
            'USER_TOPICS' => $getglobaltopics
        ));
    }
    
    
    
    
}