#include <stdio.h>
#include <sys/msg.h>
#include <stdlib.h>
#include "msg_buf.h"

int main() {
    int msgqid;
    key_t key = 0x123;
    int msgflag = IPC_CREAT|0666;
    struct msqid_ds buf;
    int ret;
    int i;
    struct msgbuf mbuf;

    if ((msgqid = msgget(key, msgflag)) < 0) {
        printf("message queue create failed \n");
        exit(-1);
    } else {
        printf("message queue created, queue id is %d \n", msgqid);

        for (i = 0; i < 3; i++) {
            ret = msgrcv(msgqid, &mbuf, sizeof(mbuf.mtext), 0, 0);
        
            if (ret == -1) {
                printf("no message \n");
                return -1;
            } else {
                printf("mtype is %ld, message is %s \n", mbuf.mtype, mbuf.mtext);
            }
        }
    }   

    return 0;
}
