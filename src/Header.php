<?php

namespace MeCab;

class Header
{
    public const C_DEFINITION = <<<'DEFINITION'
/**
 * DictionaryInfo structure
 */
struct mecab_dictionary_info_t {
  /**
   * filename of dictionary
   * On Windows, filename is stored in UTF-8 encoding
   */
  const char                     *filename;

  /**
   * character set of the dictionary. e.g., "SHIFT-JIS", "UTF-8"
   */
  const char                     *charset;

  /**
   * How many words are registered in this dictionary.
   */
  unsigned int                    size;

  /**
   * dictionary type
   * this value should be MECAB_USR_DIC, MECAB_SYS_DIC, or MECAB_UNK_DIC.
   */
  int                             type;

  /**
   * left attributes size
   */
  unsigned int                    lsize;

  /**
   * right attributes size
   */
  unsigned int                    rsize;

  /**
   * version of this dictionary
   */
  unsigned short                  version;

  /**
   * pointer to the next dictionary info.
   */
  struct mecab_dictionary_info_t *next;
};

/**
 * Path structure
 */
struct mecab_path_t {
  /**
   * pointer to the right node
   */
  struct mecab_node_t* rnode;

  /**
   * pointer to the next right path
   */
  struct mecab_path_t* rnext;

  /**
   * pointer to the left node
   */
  struct mecab_node_t* lnode;

  /**
   * pointer to the next left path
   */

  struct mecab_path_t* lnext;

  /**
   * local cost
   */
  int                  cost;

  /**
   * marginal probability
   */
  float                prob;
};

/**
 * Node structure
 */
struct mecab_node_t {
  /**
   * pointer to the previous node.
   */
  struct mecab_node_t  *prev;

  /**
   * pointer to the next node.
   */
  struct mecab_node_t  *next;

  /**
   * pointer to the node which ends at the same position.
   */
  struct mecab_node_t  *enext;

  /**
   * pointer to the node which starts at the same position.
   */
  struct mecab_node_t  *bnext;

  /**
   * pointer to the right path.
   * this value is NULL if MECAB_ONE_BEST mode.
   */
  struct mecab_path_t  *rpath;

  /**
   * pointer to the right path.
   * this value is NULL if MECAB_ONE_BEST mode.
   */
  struct mecab_path_t  *lpath;

  /**
   * surface string.
   * this value is not 0 terminated.
   * You can get the length with length/rlength members.
   */
  const char           *surface;

  /**
   * feature string
   */
  const char           *feature;

  /**
   * unique node id
   */
  unsigned int          id;

  /**
   * length of the surface form.
   */
  unsigned short        length;

  /**
   * length of the surface form including white space before the morph.
   */
  unsigned short        rlength;

  /**
   * right attribute id
   */
  unsigned short        rcAttr;

  /**
   * left attribute id
   */
  unsigned short        lcAttr;

  /**
   * unique part of speech id. This value is defined in "pos.def" file.
   */
  unsigned short        posid;

  /**
   * character type
   */
  unsigned char         char_type;

  /**
   * status of this model.
   * This value is MECAB_NOR_NODE, MECAB_UNK_NODE, MECAB_BOS_NODE, MECAB_EOS_NODE, or MECAB_EON_NODE.
   */
  unsigned char         stat;

  /**
   * set 1 if this node is best node.
   */
  unsigned char         isbest;

  /**
   * forward accumulative log summation.
   * This value is only available when MECAB_MARGINAL_PROB is passed.
   */
  float                 alpha;

  /**
   * backward accumulative log summation.
   * This value is only available when MECAB_MARGINAL_PROB is passed.
   */
  float                 beta;

  /**
   * marginal probability.
   * This value is only available when MECAB_MARGINAL_PROB is passed.
   */
  float                 prob;

  /**
   * word cost.
   */
  short                 wcost;

  /**
   * best accumulative cost from bos node to this node.
   */
  long                  cost;
};

/**
 * Parameters for MeCab::Node::stat
 */
enum {
  /**
   * Normal node defined in the dictionary.
   */
  MECAB_NOR_NODE = 0,
  /**
   * Unknown node not defined in the dictionary.
   */
  MECAB_UNK_NODE = 1,
  /**
   * Virtual node representing a beginning of the sentence.
   */
  MECAB_BOS_NODE = 2,
  /**
   * Virtual node representing a end of the sentence.
   */
  MECAB_EOS_NODE = 3,

  /**
   * Virtual node representing a end of the N-best enumeration.
   */
  MECAB_EON_NODE = 4
};

/**
 * Parameters for MeCab::DictionaryInfo::type
 */
enum {
  /**
   * This is a system dictionary.
   */
  MECAB_SYS_DIC = 0,

  /**
   * This is a user dictionary.
   */
  MECAB_USR_DIC = 1,

  /**
   * This is a unknown word dictionary.
   */
  MECAB_UNK_DIC = 2
};

/**
 * Parameters for MeCab::Lattice::request_type
 */
enum {
  /**
   * One best result is obtained (default mode)
   */
  MECAB_ONE_BEST          = 1,
  /**
   * Set this flag if you want to obtain N best results.
   */
  MECAB_NBEST             = 2,
  /**
   * Set this flag if you want to enable a partial parsing mode.
   * When this flag is set, the input |sentence| needs to be written
   * in partial parsing format.
   */
  MECAB_PARTIAL           = 4,
  /**
   * Set this flag if you want to obtain marginal probabilities.
   * Marginal probability is set in MeCab::Node::prob.
   * The parsing speed will get 3-5 times slower than the default mode.
   */
  MECAB_MARGINAL_PROB     = 8,
  /**
   * Set this flag if you want to obtain alternative results.
   * Not implemented.
   */
  MECAB_ALTERNATIVE       = 16,
  /**
   * When this flag is set, the result linked-list (Node::next/prev)
   * traverses all nodes in the lattice.
   */
  MECAB_ALL_MORPHS        = 32,

  /**
   * When this flag is set, tagger internally copies the body of passed
   * sentence into internal buffer.
   */
  MECAB_ALLOCATE_SENTENCE = 64
};

/**
 * Parameters for MeCab::Lattice::boundary_constraint_type
 */
enum {
  /**
   * The token boundary is not specified.
   */
  MECAB_ANY_BOUNDARY = 0,

  /**
   * The position is a strong token boundary.
   */
  MECAB_TOKEN_BOUNDARY = 1,

  /**
   * The position is not a token boundary.
   */
  MECAB_INSIDE_TOKEN = 2
};

typedef struct mecab_t mecab_t;
typedef struct mecab_node_t mecab_node_t;

mecab_t* mecab_new(int argc, const char **argv);
mecab_t* mecab_new2(const char *arg);
const char* mecab_version();
const char* mecab_strerror(mecab_t *mecab);
void mecab_destroy(mecab_t *mecab);
const char* mecab_sparse_tostr(mecab_t *mecab, const char *str);
const mecab_node_t* mecab_sparse_tonode(mecab_t *mecab, const char*);
const char* mecab_format_node(mecab_t *mecab, const mecab_node_t *node);
DEFINITION;
}
